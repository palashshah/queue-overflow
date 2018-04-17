# Queue Overflow
Discussion forums are amazing place for like minded people to come, browse, read and write, on the topics which they really care about.


## How to Run the Code?
This section describes how the app can be viewed in action.

```
git clone https://github.com/palashshah/queue-overflow.git queue-overflow
cd queue-overflow
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

If you want dummy data and add demo users, then run this-

```
php artisan db:seed
```

To run the server,
```
php artisan serve
```

Once the application is running, go to the following [link](http://localhost:8000).
The admin account's username and password is  
```
Username: admin@admin.com
Password: secret
```

The user account's username and password is  
```
Username: demo@user.com
Password: secret
```


## Features
This section contains the workflow of the application

### Karma system

- 10 points of each upvote
- -2 for downvote
- No points for comments up and downvote.
- A user can change his/her vote i.e. earlier he/she can upvote, and then later change it to downvote.
- A user can “accept answer” on his own question. This will award 20 points to author of the answer.

### Administrator has following powers:

- Make any other user (already registered) as admin.
- Edit any of question, answer or comment.
- Take or Give bonus points to any user, without the need of voting.
- Suspend any user, in this case, the user can only browse in read-only mode.

### Users can display the questions based on tags.

### Notification system in which user get notified for following things:

- A new answer has been posted on your question "question-link"
- "user-name" has up up/down voted your comment/answer on "question-link" .
- You have been awarded points by "admin-name".

### Extras

- Token based authentication on all APIs, instead of session based.
- Cool editor for writing question, answer and comments. 
- Security check for vulnerable codes in text editor while adding question/answer/comment, like omitting scripts.