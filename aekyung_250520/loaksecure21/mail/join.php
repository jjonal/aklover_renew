<script>
var cars = [],
	msg = 'item',
	i = 1,
	btn_add = document.getElementById('btn_add'),
	btn_del = document.getElementById('btn_del'),
	btn_print = document.getElementById('btn_print');

btn_add.onclick = function(){
	cars.push(msg+i);
	console.log(cars)
	i++;
}

btn_del.onclick = function(){
	cars.pop(msg+i);
	console.log(cars)
	i--;
}

btn_print.onclick = function(){
	console.log(cars.join(', '));
}

function delete_Array(array,num){
   for(n=0; n< array.length;n++){
    if(array[n] == num){
     array.splice(n,1);
     return array;
    }
   }
  }

</script>
<button type="button" id="btn_add">배열추가</button>
<button type="button" id="btn_del">배열삭제</button>
<button type="button" id="btn_print">현재배열</button>split("-"); 

