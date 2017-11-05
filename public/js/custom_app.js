
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function datepickerMaxDate(){

    var today = new Date();
    var currYear = today.getFullYear();
    var nextYear = today.getFullYear() + 1;
    var currMonth = today.getMonth();

    var year = currMonth>7 && currMonth<=11 ? nextYear : currYear;
    var month = 7;
    var day = 31;

    return new Date(year, month, day);
};

function orthodoxEasterSunday(year)
{
    d = (year%19*19+15)%30;

    e = (year%4*2+year%7*4-d+34)%7+d+127;

    month = Math.floor(e/31);

    a = e%31 + 1 + (month > 4);

    return  moment(new Date(year, (month-1), a));
}

function isNotPast(date)
{
    var selectedDate = date.format(dateFormat);
    var today = moment().format(dateFormat);

    return selectedDate >= today;
}

function isNotSunday(date)
{
    
    day = date.day();

    return day > 0;
}