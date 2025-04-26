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
