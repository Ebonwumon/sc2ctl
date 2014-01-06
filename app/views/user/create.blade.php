@extends('layout')

@section('title')
Register
@stop

@section('content')
<div class="padded-content">
  @if ($errors->count() > 0)
    <div class="errors" style="display:block;">
      <ul>
        @foreach($errors->all() as $message)
          <li>{{ $message }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  {{ Form::open(array('route' => 'user.store', 'method' => 'post', 'class' => 'pure-form pure-form-aligned')) }}
    <div id="login1"/>
      <h3>Step 1</h3>
      <p>First, let's some identifying information for you</p>
      <div class="pure-control-group">
        {{ Form::label('email') }}
        {{ Form::text('email', null, array('class' => 'validates val-unique')) }} <span class="feedback"></span>
      </div>
      <div class="pure-control-group">
        {{ Form::label('username') }}
        {{ Form::text('username', null, array('class' => 'validates val-unique')) }} <span class="feedback"></span>
      </div>

    </div>

    <div id="login2">
      <h3>Step 2</h3>
      <p>Choose a password that you'll use to login. We don't enforce any rules about password security, but
        don't be stupid
      </p>
      <div class="pure-control-group">
        {{ Form::label('password') }}
        {{ Form::password('password', array('class' => 'validates val-matches validated')) }}
        <span class="feedback"></span>
      </div>

      <div class="pure-control-group">
        {{ Form::label('confirmation') }}
        {{ Form::password('password_confirmation', array('class' => 'validates val-matches')) }}
        <span class="feedback"></span>
      </div>
    </div>

    <div id="login3">
      <h3>Step 3</h3>
      <p>Now let's get your battle.net information settled. Unfortunately, this information is required
      to register. If you want to participate, go out and get Starcraft II!</p>
      <p>
        To use this section, you'll need your battle.net URL. It will look something like this:
        <a href="http://us.battle.net/sc2/en/profile/2275201/1/bonywonix/">
          http://us.battle.net/sc2/en/profile/2275201/1/bonywonix/
        </a>. After inputting the URL, click "Fill Form" and many fields will be filled in automatically for you.
      </p>

      <div class="pure-control-group">
        {{ Form::label('bnet_url') }}
        {{ Form::text('bnet_url', null, array('class' => 'validates val-bnet_url')) }} 
        <span class="feedback"></span>
        
        {{ Form::button('Fill Form', array('id' => 'fillBnet', 'class' => 'pure-button pure-button-secondary')) }}
      </div>

      <div class="pure-control-group">
        {{ Form::label('bnet_id') }}
        {{ Form::input('number', 'bnet_id', null, array('class' => ' validates val-unique', 'placeholder' => "Press Fill Form")) }} <span class="feedback"></span>
      </div>
    
      <div class="pure-control-group">
        {{ Form::label('bnet_name', "Ingame Name") }}
        {{ Form::text('bnet_name', null, array('class' => 'validates val-present')) }} <span class="feedback"></span>
      </div>

      <div class="pure-control-group">
        {{ Form::label('char_code') }}
        {{ Form::Input('number', 'char_code', null,  array('class' => 'validates val-present')) }} <span class="feedback"></span>
      </div>

      <div class="pure-control-group">
        {{ Form::label('league') }}
        {{ Form::select('league', array('Bronze' => 'Bronze', 'Silver' => 'Silver', 'Gold' => 'Gold', 
                        'Platinum' => 'Platinum', 'Diamond' => 'Diamond', 'Master' => 'Master', 
                        'Grandmaster' => 'Grandmaster'), 
                null, array('class' => 'validates val-present')) }} <span class="feedback"></span>
      </div>

    </div>
    <div class="pure-controls">
    {{ Form::submit('Register', array('class' => 'pure-button pure-button-good')) }}
    </div>
  {{ Form::close() }}
</div>
<script>
	function generateFeedback(obj, success, reason) {
		if (success) {
			$(obj).removeClass('validated');
			$(obj).next().removeClass().addClass("error").html($(obj).attr('name') + ' is ' + reason.fail);	
		} else {
			$(obj).addClass('validated');
			$(obj).next().removeClass().addClass("success").html($(obj).attr('name') + " is " + reason.success);
		}

		// now we check if section is full

		var section = $(obj).parents('[id^=login]');
		var candidates = section.find('.validates');
		var incomplete = false;
		candidates.each( function(i) {
			if (!$(candidates[i]).hasClass('validated')) {
				incomplete = true;
			}
		});
		
		if (!incomplete) { 
			section.attr('data-complete', 'true');
		} else {
			section.removeAttr('data-complete');
		}
	}

	$('.validates').change(function() {
      var checks = $(this).attr('class').split(' ');

		for ( var i in checks) {
			if (checks[i].substring(0, 4) === "val-") {
				var cl = checks[i].substring(4, checks[i].length);
				var obj = this;
				switch (cl) {
					case "unique":
						if (!$(this).val()) {
							return generateFeedback(obj, 1, { fail: "required" });
						}
						$.ajax({
							type: "GET",
							url: "/user/checktaken/" + $(this).attr('name') + "/" + $(this).val(),
							dataType: "json",
							success: function(data) { 
								generateFeedback(obj, parseInt(data.taken), { fail: "already taken", success: "is available" }) 
							},
							error: function(jqxhr) { console.log(jqxhr); }
						});
						
						$(this).next().removeClass().addClass('feedback').show('fast').html("Checking...");
					break;
					case "bnet_url":
						return generateFeedback(obj, !ValidURL($(this).val()), { fail: "not a URL", success: "a valid URL" });
						break;
					default: 	
					case "present":
						return generateFeedback(obj, !$(this).val(), { fail: "required", success: "entered properly" }); break;
          case "matches":
            return generateFeedback(confObj(obj), !matches(obj), { fail: "different", success: "matching"}); break;
				}
			}
		}
	});

	$('#fillBnet').click(function() {
		var arr = $('#bnet_url').val().split('/');
		$('#bnet_id').val(arr[6]).change();
		$('#bnet_name').val(arr[8]).change();
	});

  function confObj(obj) {
    var name = $(obj).attr('name');
    if (name.indexOf("confirmation") == -1) {
      return target = $('[name=' + name + "_confirmation]");
    } else {
      return obj;
    }

  }

  function matches(obj) {
    console.log("here");
    var name = $(obj).attr('name');
    if (name.indexOf("confirmation") == -1) {
      var target = $('[name=' + name + "_confirmation]");
    } else {
      var target = $('[name=' + name.split('_')[0] + ']');
    }

    if ($(obj).val() == target.val()) {
      return true;
    }
    return false;
  }

	function ValidURL(str) {
		 var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
		   '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
		     '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
			   '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
			     '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
				   '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
		if(!pattern.test(str)) {
			return false;
		} else {
			return true;
		}
	}

	$('form').submit(function(e) {
		// Check that everything is complete
		var sections = $(this).children('[id^=login]');
		var valid = true;
		sections.each( function(i) {
			if (!$(sections[i]).data('complete')) {
				valid = false;
				$(sections[i]).find('.validates').change();
			}
		});
		return valid;
	});
</script>

@stop
