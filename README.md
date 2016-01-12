# php-quiz-app
This is a small quiz app to test people if the understood the rules of your server
## Editing
You can edit the template.html like you want but keep it in Bootstrap style and add the ```id="inside"``` property to the element where the HTML should be written
## Usage
To use is call the index.php with the id of the Quiz you want to open: ```/?id=1```
## questions.config
The questions.config has a simple Syntax:

Lines with * start a new quiz

Characters after | are the id

~ defines the Callback (CLI) ($UUID is being replaced with the UUID used)

$ settings max. errors|max. errors per question

; = Start a new Question

? = splits question and answers

| = new answer

} = this answer is true (can be multiple choise)


Example:
```
*Quiz Title|ID
;Question?answer1|answer2}|answer3
~echo "true" ./completed$UUID
$ 2|5
```
