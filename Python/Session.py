from flask import Flask, session, redirect, url_for

app = Flask(__name__)
app.secret_key = 'your_secret_key'  # Required for session management

@app.route('/')
def index():
    # If the user is already logged in, redirect to the welcome page
    if 'userid' in session:
        return redirect(url_for('welcome'))
    return "You are not logged in."

@app.route('/welcome')
def welcome():
    return "Welcome to the dashboard!"

if __name__ == '__main__':
    app.run(debug=True)