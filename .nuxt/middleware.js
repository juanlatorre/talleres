const middleware = {}

middleware['router-auth'] = require('@/middleware/router-auth.js');
middleware['router-auth'] = middleware['router-auth'].default || middleware['router-auth']

export default middleware
