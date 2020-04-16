  pipeline {
    agent any
    stages {
        stage('Git Cloning') {
            steps {
                git credentialsId: '45db9d1f-aacf-45b1-a1b0-96d06a8ad156', url: 'https://github.com/Deepak1919-admin/Test-project.git'
            }
        }
        stage('ssh publisher') {
            steps {
                sshPublisher(publishers: [sshPublisherDesc(configName: 'Remote-GoogleCloud-Server', transfers: [sshTransfer(cleanRemote: false, excludes: '', execCommand: '', execTimeout: 120000, flatten: false, makeEmptyDirs: false, noDefaultExcludes: false, patternSeparator: '[, ]+', remoteDirectory: '', remoteDirectorySDF: false, removePrefix: '', sourceFiles: '**/*')], usePromotionTimestamp: false, useWorkspaceInPromotion: false, verbose: false)])
                    }
        }
        stage('Deploy') {
            steps {
                echo 'Deploying....'
            }
        }
    }
}
