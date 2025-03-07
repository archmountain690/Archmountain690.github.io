import sqlite3
from flask import Flask, request, redirect, url_for, render_template
import bcrypt

app = Flask(__name__)
app.secret_key = 'your_secret_key'

# Database configuration
DB_NAME = "../Database/Logs.db"

def connect_db():
    try:
        conn = sqlite3.connect(DB_NAME)
        return conn
    except sqlite3.Error as e:
        print(f"Error: connection error. {e}")
        return None

@app.route('/register', methods=['GET', 'POST'])
def register():
    error = ""
    if request.method == 'POST':
        first_name = request.form['firstname']
        last_name = request.form['lastname']
        address1 = request.form['addressline1']
        address2 = request.form['addressline2']
        postcode = request.form['postcode']
        city = request.form['city']
        email = request.form['email']
        password = request.form['password']
        confirm_password = request.form['confirmpassword']
        
        if password != confirm_password:
            error = "Passwords do not match."
        elif len(password) < 6:
            error = "Password must be at least 6 characters long."
        else:
            hashed_password = bcrypt.hashpw(password.encode('utf-8'), bcrypt.gensalt())
            conn = connect_db()
            if conn:
                cursor = conn.cursor()
                cursor.execute("SELECT * FROM users WHERE email = ?", (email,))
                if cursor.fetchone():
                    error = "Email is already registered."
                else:
                    cursor.execute("INSERT INTO users (FirstName, LastName, Address1, Address2, PostCode, City, Email, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
                                   (first_name, last_name, address1, address2, postcode, city, email, hashed_password))
                    conn.commit()
                    conn.close()
                    return "Registration successful!"
    return render_template('register.html', error=error)

if __name__ == '__main__':
    app.run(debug=True)
