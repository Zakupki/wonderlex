  <div class="analytics">

	<div class="widget analytics-graph" data-siteid="<?=$_SESSION['Site']['id'];?>">

    <div class="h1">
      <h1>Обзор трафика</h1>
      <div class="graph-select">
        <a class="month" data-type="1">Месяц</a>
        <a class="year" data-type="2">Год</a>
      </div>
    </div>

		<div class="graph-container">
			<div id="graph-1" class="graph"></div>
			<div id="graph-2" class="graph"></div>
		</div>

    <div class="stats">
      <table class="stats-table"></table>
    </div>
	</div>
</div>
