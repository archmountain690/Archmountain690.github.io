import sqlite3

# Database configuration
DB_NAME = "../Database/Logs.db"

def connect_db():
    try:
        conn = sqlite3.connect(DB_NAME)
        return conn
    except sqlite3.Error as e:
        print(f"Error: connection error. {e}")
        return None

# Establish database connection
db = connect_db()

if db is None:
    exit(1)