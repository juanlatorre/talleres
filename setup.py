import flask from flask

app = Flask(__name__)

@app.route('/')
def index():
  return "Hello, World!"