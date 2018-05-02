var gulp = require('gulp');
var handlebars = require('gulp-compile-handlebars');
var rename = require('gulp-rename');
var templateData = require('./data.json');
var through = require('through2');
var fs = require('fs');
var transform = require('gulp-transform');
var htmlbeautify = require('gulp-html-beautify');
var gulpIgnore = require('gulp-ignore');

gulp.task('default', function () {
    var templateContent = fs.readFileSync("./views/layout.hbs", "utf8");
    
    options = {
        ignorePartials: true, //ignores the unknown footer2 partial in the handlebars template, defaults to false 
        helpers : {
            capitals : function(str){
                return str.toUpperCase();
            },
            json: function(context) {
                return JSON.stringify(context);
            }
        }
    }
 
    return gulp.src('views/*.hbs')
        .pipe(gulpIgnore.exclude('layout.hbs'))
        .pipe(transform('utf8', attachLayout(templateContent)))
        .pipe(handlebars(templateData, options))
        .pipe(htmlbeautify({ indentSize: 2 }))
        .pipe(rename(function (path) {
            path.extname = ".html"
        }))
        .pipe(gulp.dest('dist'));
});

function attachLayout(template) {
    return function (content, file) {
        return template.replace('{{{ body }}}', content);
    }
}