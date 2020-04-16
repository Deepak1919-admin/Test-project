 pipeline {
        agent any 
        stages {
           stage ("Git cloning") {
                steps {
                    git credentialsId: '13f399e0-8ef4-4f2b-b3b7-3128ed5a4ada', url: 'https://github.com/Deepak1919-admin/Test-project.git'
                }
           }
           stages {
               stage ("Ssh Publisher") {
                    steps {
                        sshPublisher(publishers: [sshPublisherDesc(configName: 'webserver', transfers: [sshTransfer(cleanRemote: false, excludes: '', execCommand: '', execTimeout: 120000, flatten: false, makeEmptyDirs: false, noDefaultExcludes: false, patternSeparator: '[, ]+', remoteDirectory: '', remoteDirectorySDF: false, removePrefix: '', sourceFiles: '**/*')], usePromotionTimestamp: false, useWorkspaceInPromotion: false, verbose: false)])
                    }                
               }
           }
        }
 }
