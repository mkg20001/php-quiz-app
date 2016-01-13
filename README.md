# php-quiz-app
This is a small quiz app to test people if the understood the rules of your server
## Editing
You can edit the template.html like you want but keep it in Bootstrap style and add the ```id="inside"``` property to the element where the HTML should be written
## Usage
To use it just call it with the UUID located in ```./uuid```: ```/?uuid=1```
## questions.config
The questions.config has a simple Syntax:

Lines with * start a new quiz

Characters after | are the id

~ defines the Callback (CLI) ($UUID and $DATA are being replaced)

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

##UUID System
To create a UUID simply write the following in a file located in ```./uuid```
```

QuizID
additional data (string)
```
Example:
```

1
testuser
```
