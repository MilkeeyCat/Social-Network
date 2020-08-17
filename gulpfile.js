const 
gulp = require("gulp"),
sass = require("gulp-sass"),
autoprefixer = require("gulp-autoprefixer"),
cleancss = require("gulp-clean-css"),
rename = require("gulp-rename"),
livereload = require("gulp-livereload");

const basePath = "./public";

gulp.task("autoreload-scss", () => {
    return gulp.src(basePath + "/scss/**/*.scss")
    .pipe(sass().on("error", sass.logError))
    .pipe(autoprefixer({
        browsers: "last 3 versions",
        cascade: false
    }))
    .pipe(gulp.dest(basePath + "/css/"))
    .pipe(cleancss({compability: "ie8"}))
    .pipe(rename({suffix: ".min"}))
    .pipe(gulp.dest(basePath + "/css/"))
    .pipe(livereload());

    gulp.series("autoreload-html");
});
gulp.task("autoreload-html", () => {
    return gulp.src("**/*.html")
    .pipe(livereload());
});
gulp.task("autoreload-js", () => {
    return gulp.src(basePath + "/js/*.js")
    .pipe(livereload());

    gulp.series("autoreload-html");
});
gulp.task("default", () => {
    livereload.listen();
    gulp.watch(basePath + "/scss/**/*.scss", gulp.series('autoreload-scss'));
    gulp.watch(basePath + "/js/*.js", gulp.series('autoreload-js'));
    gulp.watch("**/*.html", gulp.series('autoreload-html'));
});