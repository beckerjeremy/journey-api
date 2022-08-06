/**
* JetBrains Space Automation
* This Kotlin-script file lets you automate build activities
* For more info, see https://www.jetbrains.com/help/space/automation.html
*/

job("Run Tests") {
    container(image = "composer:2.3") {
    	shellScript {
            content =  """
            		echo Installing dependencies...
            		composer install
                    
                    echo Running tests...
                    ./vendor/bin/phpunit --log-junit ~/phpunit/junit.xml
                    
                    echo Uploading artifacts...
                    SOURCE_PATH=~/phpunit/junit.xml
                	TARGET_PATH=logs/${'$'}JB_SPACE_EXECUTION_NUMBER/
                	REPO_URL=http://packages.becker.dev/files/p/journey-api/files
                	curl -i -H "Authorization: Bearer ${'$'}JB_SPACE_CLIENT_TOKEN" -F file=@"${'$'}SOURCE_PATH" ${'$'}REPO_URL/${'$'}TARGET_PATH
                """
        }
    }
}
