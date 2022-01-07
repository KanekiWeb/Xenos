function SearchByGrade(grade) {
    srv = window.location.href.split("?badge=")[0]
    window.location.href=srv+"?badge="+grade.value;
}
