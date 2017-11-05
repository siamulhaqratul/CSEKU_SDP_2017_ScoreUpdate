function accordion(index) {
	var collapse = document.getElementsByClassName('collapse');

	for (i = 0; i < collapse.length; i++) {
		//collapse[i].style.display = 'none';
		if (i == index) {
			if (collapse[index].style.display == 'none') {
				collapse[index].style.display = 'block';
			}
			else {
				collapse[index].style.display = 'none';
			}		
		}
		else {
			collapse[i].style.display = 'none';
		}
	}

	
}