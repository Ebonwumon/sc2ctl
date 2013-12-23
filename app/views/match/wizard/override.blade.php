<h4>Player for {{ $team1->tag }}: <span class="currentPlayer player1">{{ $game->playerone->username }}</span></h4>
<div class="selectable selectOne box" id="team1">
	@include('user/multipleCardPartial', array('members' => $team1->members))
</div>
<button class="expand-left selectOne pure-button pure-button-good" data-register="true">
	<span class="spinner"></span>Choose
</button><span class="error"></span>
<br />
<h4>Player for {{ $team2->tag }}: <span class="currentPlayer player2">{{ $game->playertwo->username }}</span></h4>
<div class="selectable selectOne box" id="team2">
	@include('user/multipleCardPartial', array('members' => $team2->members))
</div>
<button class="expand-left selectOne pure-button pure-button-good" data-register="true">
	<span class="spinner"></span>Choose
</button><span class="error"></span>

<hr />

<h3>Choose Winner</h3>
<div class="selectable selectOne box winners">
	<div class="pure-g-r">
		<div class="pure-u-1-2">
			<h4>{{ $team1->tag }}</h4>
			<div class="player1">
				@include('user/profileCardPartial', array('member' => $game->playerone))
			</div>
		</div>
		<div class="pure-u-1-2">
			<h4>{{$team2->tag }}</h4>
			<div class="player2">
				@include('user/profileCardPartial', array('member' => $game->playertwo))
			</div>
		</div>
	</div>
</div>
<button class="selectOne expand-left pure-button pure-button-good">
	<span class="spinner"></span>Declare Winner
</button><span class="error"></span>
</div>
<br />

@if ($gno < $match->bo)

	<a href="{{URL::route('match.wizard.nextgame', array($match->id, $gno)) }}" 
		class="pure-button pure-button-secondary right expand-left">
		<span class="spinner"></span>Next Game
	</a>
@else
	<a href="{{URL::route('home') }}" class="pure-button pure-button-secondary right">
		Finish
	</a>
@endif

<script type="text/javascript">
	bindSelectableCards();
	bindSelectableButtons();
	function selectOneAction(selected, obj) {
		$(obj).attr('data-loading', 'true');
		var myData = Object();
		var id = gatherSelected(selected)[0];
		var winners = $('.winners');
		if ($(obj).data('register')) {
			var current = $(obj).prevAll('h4:first').find('.currentPlayer');
			var player = (current.hasClass('player1')) ? "player1" : "player2";
			var username = selected.find('.username').html();
						
			myData[player] = id;
		} else {
			myData['winner'] = id;	
		}
		

		$.ajax({
			type: "PUT",
			url: '{{ URL::route("game.update", $game->id) }}',
			dataType: "json",
			data: myData,
			success: function(data) {
				if (!data.status) {
					if ($(obj).data('register')) {
						current.html(username);
						$(obj).removeAttr('data-loading');
						winners.find('.' + player).children().remove();
						selected.removeClass('selected').clone().appendTo(winners.find('.' + player));
						bindSelectableCards();
					} else {
						winners.find('.winner').removeClass("winner");
						selected.addClass('winner');
						$(obj).removeAttr('data-loading');
					}
				}
			},
			error: function(jqxhr) {
				dispError(obj, "AJAX Error. Please tell an adult");
				console.log(jqxhr);
			}
		});
	}
</script>
