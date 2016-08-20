'use strict'

const path = require('path')

module.exports = {
  entry: __dirname + "/resources/assets/js/app.js",
  output: {
    path: __dirname + '/public/js',
    filename:'bundle.js'
  },  
  resolve: {
    extensions: ["", ".js", ".jsx"]
    //node_modules: ["web_modules", "node_modules"]  (Default Settings)
  },
  module: {
    loaders: [
      {
        test: /.jsx?$/,
        //include: path.join(__dirname, 'resources/assets'),
        exclude: /node_modules/,
        loader: 'babel',
        query: {
          presets: ['es2015', 'react']
        }
      },
    ]
  },
}