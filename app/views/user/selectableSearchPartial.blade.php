{{ Form::open(array('class' => 'pure-form search search-users')) }}
	<label for="search">Search user database</label>
	{{ Form::text('search', null, array('placeholder' => 'Enter Username')) }}
	<?php if (!isset($searchParams)) $searchParams = ""; ?>
	{{ Form::hidden('search_params', $searchParams) }}
	{{ Form::submit('Search', array('class' => 'pure-button pure-button-secondary')) }}
{{ Form::close() }}
<br />
<div class="selectable results"></div>
<br />
