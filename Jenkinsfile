pipeline {
    agent any

    environment {
        // Ajuste para onde seu container ou app WebBoi vai ser enviado
        REMOTE_USER = 'ubuntu'
        REMOTE_HOST = 'localhost'
        REMOTE_PATH = '/home/ubuntu/containers/webboi/html'
    }

    stages {
        stage('Clonar projeto') {
            steps {
                git branch: 'main', url: 'https://github.com/lourivalvsj/webboi.git'
            }
        }

        stage('Buildar projeto') {
            steps {
                sh '''
                composer install --no-interaction --prefer-dist
                '''
            }
        }

        stage('Enviar arquivos via rsync') {
            steps {
                sh """
                rsync -avz --delete-after \
                    --exclude '.git' \
                    --exclude 'node_modules' \
                    --exclude 'vendor' \
                    ./ ${REMOTE_USER}@${REMOTE_HOST}:${REMOTE_PATH}
                """
            }
        }

        stage('Deploy no servidor') {
            steps {
                sh """
                ssh ${REMOTE_USER}@${REMOTE_HOST} '
                    cd ${REMOTE_PATH} &&
                    docker compose pull &&
                    docker compose up -d --build
                '
                """
            }
        }
    }

    post {
        success {
            echo 'Deploy realizado com sucesso! 🚀'
        }
        failure {
            echo 'Falhou o deploy ❌'
        }
    }
}
