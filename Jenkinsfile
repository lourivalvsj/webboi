pipeline {
    agent any

    environment {
        REMOTE_USER = 'ubuntu'
        REMOTE_HOST = 'localhost'
        REMOTE_PATH = '/home/ubuntu/containers/webboi/html'
        CONTAINER_NAME = 'webboi'
    }

    stages {
        stage('Clonar projeto') {
            steps {
                git branch: 'main', url: 'https://github.com/lourivalvsj/webboi.git'
            }
        }

        stage('Enviar arquivos via rsync') {
            steps {
                sh """
                rsync -avz --delete-after \
                    --exclude '.git' \
                    --exclude '.env' \
                    --exclude 'node_modules' \
                    --exclude 'vendor' \
                    --exclude 'storage/' \
                    --exclude 'bootstrap/cache/' \
                    ./ ${REMOTE_PATH}/
                """
            }
        }

        stage('Instalar dependências dentro do container') {
            steps {
                sh """
                docker exec -i ${CONTAINER_NAME} bash -c '
                    cd /var/www && \
                    composer install --no-interaction --prefer-dist
                '
                """
            }
        }

        stage('Preparar Laravel (cache, key, permissions)') {
            steps {
                sh """
                docker exec -i ${CONTAINER_NAME} bash -c '
                    cd /var/www && \
                    if [ ! -f .env ]; then cp .env.example .env; fi && \
                    php artisan key:generate --force && \
                    php artisan config:clear && \
                    php artisan cache:clear && \
                    php artisan route:clear && \
                    php artisan view:clear && \
                    php artisan config:cache && \
                    php artisan storage:link && \
                    chown -R www-data:www-data storage bootstrap/cache && \
                    chmod -R 775 storage bootstrap/cache
                '
                """
            }
        }

        stage('Rodar migrations e seeders') {
            steps {
                sh """
                docker exec -i ${CONTAINER_NAME} bash -c '
                    cd /var/www && \
                    php artisan migrate --force && \
                    php artisan db:seed --force || true
                '
                """
            }
        }

        stage('Restartar o container') {
            steps {
                sh "docker restart ${CONTAINER_NAME}"
            }
        }
    }

    post {
        success {
            echo '🚀 Deploy realizado com sucesso dentro do container!'
        }
        failure {
            echo '❌ Falhou o deploy!'
        }
    }
}
