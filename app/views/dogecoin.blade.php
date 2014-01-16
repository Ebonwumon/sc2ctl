@extends('layout')

@section('title')
wow such showmatch
@stop

@section('background')
doge-background background-wrapper
@stop

@section('content')
<div id="mainpage" class="wow-so-comic-sans">
    
  <div class="floating-color">
    <h1 class="content-box-title title-massive">SC2CTL Dogecoin Series: Deimos vs LYGF</h1>
  </div>
  <div class="padded-content">
    <div class="pure-g-r">
      <div class="pure-u-1-3">
        <div class="main-content-box floating-color">
          <h2 class="content-box-title">What is dogecoin?</h2>
          <p>
            <a href="http://dogecoin.com">dogecoin</a> is an online-only cryptocurrency much like Bitcoin.
            Coins are generated through solving cryptographic problems of increasing difficulty, and every
            member of the dogecoin network also acts as a banker to keep all transactions honest. What this means
            in the context of this match, is that dogecoins are a <strong>fun</strong> currency that exist
            inside computers and can be paid out to winners <strong>instantly</strong>, no questions asked.
          </p>
        </div>
      </div>
      <div class="pure-u-2-3">
        <div class="main-content-box floating-color">
          <h2 class="content-box-title">wow such info</h2>
          <strong>When</strong>: Thursday, Jan 27th @ 8PM EST<br />
          <strong>Where</strong>: <a href="{{ URL::route('stream') }}">SC2CTL Stream Page</a><br />
          <strong>Prizes</strong>: 20k dogecoin starting pool (donation information below)<br />
          <strong>Teams</strong>: Deimos vs LYGF<br />
          <strong>Format</strong>: Six games of fixed-rosters, plus ace match 
        </div>
      </div>
    </div>
  </div>
  <div class="splash">
    <div class="pure-g">
      <div class="pure-u-1-3">
        <div class="l-box">
          <img src="/img/bertandernie.jpg" />
        </div>
      </div>
      <div class="pure-u-2-3">
        <h1 class="splash-head">many livecast</h1>
        <h3 class="splash-subhead" style="color:rgb(181, 91, 2);">
          Our excellent casting team of <a href="http://twitter.com/wingnutsc">wingnutsc</a>
          and <a href="http://twitter.com/gallagation">gallagation</a> will treat you darling 
          shibes with sweet live casting over on the <a href="{{ URL::route('stream') }}">SC2CTL Stream</a>.
          <br />
          Enjoy a fine selection of "wow"s, "much"s and perhaps even some "amaze".
          <br />
          <br />
          If you're interested in checking out the VODs of previous matches, you can take a gander at the
          <a href="http://www.youtube.com/wingnutstarcraft">Archive YouTube Channel</a>
        </h3>
      </div>
    </div>
  </div>

  <br />

  <div class="splash">
    <div class="pure-g">
      <div class="pure-u-2-3">
        <h1 class="splash-head">much riches, so class</h1>
        <h3 class="splash-subhead" style="color:rgb(181, 91, 2);">
          The dogecoin pool for this event starts at <strong>TWENTY THOUSAND</strong> dogecoins. Plus,
          <a href="https://dogeapi.com">dogeapi.com</a> has offered to match contributions to the prize pool,
          up to 50k. So if some rich shibes donate a total of 50k doges, the prize pool will be at 
          <strong>one hundred and twenty thousand doges</strong>.
          <br />
          <br />
          The prize pool will be awarded per-win. So, if a player wins a game, their team will take home 1/7th
          of the prize pool. This means that, no matter what, <strong>all seven games will be played</strong>!
          If you wish you contribute, head over to the donate page on <a href="https://dogeapi.com">dogeapi</a>
          or you can send directly to the address: 
          <strong>DCqMrhmJf7no3eW5fqpsH4fU8cDsKBiqSR</strong>
          <br />
          <br/>
          The current prize pool (with donations) is: 
          <span style="font-size:150%; font-weight:bold;">{{ $total }} doge.</span>
          <br />
          <span style="font-size:70%;">
            totals pulled from <a href="http://dogeapi.com">dogeapi.com</a>
          </span>
        </h3>
      </div>
      <div class="pure-u-1-3">
        <div class="r-box">
          <img src="/img/300coin.png" />
        </div>
      </div>
    </div>
  </div>

  <br />

  <div class="splash centered">
    <div class="pure-g">
      <div class="pure-u-1-6">
        <div class="l-box">
          <img src="/img/claritygaming.png" />          
        </div>
      </div>
      <div class="pure-u-2-3">
        <h1 class="splash-head">wow, such teams, amaze</h1>
        <table class="pure-table" style="width:50%; margin:0px auto; border-color:black;">
          <thead>
          </thead>
          <tr>
            <td>Elhaym (T)</td>
            <td>Yeonsu LE</td>
            <td>Heiwa (T)</td>
          </tr>
          <tr>
            <td>Reborn (Z)</td>
            <td>Polar Night LE</td>
            <td>Astrea (P)</td>
          </tr>
          <tr>
            <td>Silky (Z)</td>
            <td>Star Station TE</td>
            <td>Prebs (Z)</td>
          </tr>
          <tr>
            <td>Shew (P)</td>
            <td>Frost LE</td>
            <td>Bones (P)</td>
          </tr>
          <tr>
            <td>Sarovati (P)</td>
            <td>Bel'Shir Vestige LE</td>
            <td>Arium (P)</td>
          </tr>
          <tr>
            <td>Poo (P)</td>
            <td>Fruitland</td>
            <td>Intense (T)</td>
          </tr>
          <tr>
            <td>ACE</td>
            <td>Habitation Station</td>
            <td>ACE</td>
          </tr>
        </table>
        <h3 class="splash-subhead" style="color:rgb(181, 91, 2);">
        </h3>
      </div>
      <div class="pure-u-1-6">
        <div class="r-box">
          <img src="/img/seedgaming.jpg" />
        </div>
      </div>

    </div>
  </div>

</div>
@stop
