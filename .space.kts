/**
* JetBrains Space Automation
* This Kotlin-script file lets you automate build activities
* For more info, see https://www.jetbrains.com/help/space/automation.html
*/

job("Hello World!") {
    container(image = "composer:2.3") {
    	shellScript {
            content =  """
            		composer install
                    ./vendor/bin/phpunit > /mnt/space/share
                """
        }
    }
    
    docker {
    	beforeBuildScript {
            "cp /mnt/space/share docker"
        }
        
        build {}
    }
}
