<?
header('Content-Type: text/html; charset=utf-8');
header("HTTP/1.1 200 ".urlencode('Добро пожаловать')."");
echo "<pre>";
print_r($_SERVER);
echo "</pre>";
?>
<script>
var req = new XMLHttpRequest();
req.open('GET', document.location, false);
req.send(null);
var headers = req.getAllResponseHeaders().toLowerCase();
alert(headers);
</script>