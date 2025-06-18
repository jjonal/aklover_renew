var monthtext=['0','1','2','3','4','5','6','7','8','9','10','11','12'];
function date_populate(dayfield, monthfield, yearfield, hero_Y , hero_M, hero_D){
    var today=new Date();
    var dayfield=document.getElementById(dayfield)
    var monthfield=document.getElementById(monthfield)
    var yearfield=document.getElementById(yearfield) 

//dayfield.options[today.getDate()]=new Option(today.getDate(), today.getDate(), true, true) //select today's day
    for (var i=0; i<32; i++)
    dayfield.options[i]=new Option(i, i)
//    dayfield.options[0] = new Option("ÀÏ", "0", true);
    dayfield.options[hero_D].selected = true;

    for (var m=0; m<13; m++)
    monthfield.options[m]=new Option(monthtext[m], monthtext[m])
//    monthfield.options[0] = new Option("¿ù", "0", true);
    monthfield.options[hero_M].selected = true;


    //monthfield.options[today.getMonth()]=new Option(monthtext[today.getMonth()], monthtext[today.getMonth()], true, true) //select today's month
    var thisyear=today.getFullYear()
//    alert(thisyear);
    for (var y=0; y<100; y++){
    yearfield.options[y] = new Option(thisyear, thisyear);
    if(thisyear==hero_Y){
        yearfield.options[y].selected = true;
    }
    thisyear-=1;
//    yearfield.options[0] = new Option("³â", "0", true);
    }


//    alert(y);
//    yearfield.options[hero_Y].selected = true;
//    yearfield.options[hero_Y].selected = true;


    //yearfield.options[0]=new Option(today.getFullYear(), today.getFullYear(), true, true) //select today's year

}