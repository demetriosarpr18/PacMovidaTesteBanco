<script>
	function abrirMenuLateral()
	{
		if(screen.width >= 375)
		{
			document.getElementById('menu').style.width ="40%";	
		}
		if(screen.width >= 1000)
		{
			document.getElementById('menu').style.width = "15%";
		}
		
	}
	
	function fecharMenuLateral()
	{
		document.getElementById('menu').style.width = "0%";
	}
</script>