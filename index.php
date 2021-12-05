<?php

$base_uri = '.';

if (isset($_GET['code'])) {
	$base_uri = '..';
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	if (isset($_GET['code'])) {
	?>

		<meta name="twitter:card" content="summary_large_image">
		<meta property="og:image" content="https://tools.dexfolio.org/i/<?= $_GET['code'] ?>.png" />
		<meta name="twitter:image" content="https://tools.dexfolio.org/i/<?= $_GET['code'] ?>.png">
		<meta name="twitter:image:alt" content="dexfolio_promo_banner">
	<?php
	}
	?>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="author" content="@mzmarkib">
	<link rel="icon" href="<?= $base_uri ?>/img/favicon.png" type="image/png">
	<title>Listing Checker: Dexfolio App Token Listing Checker</title>
	<link rel="stylesheet" href="<?= $base_uri ?>/css/coloris.min.css" />
	<link rel="stylesheet" href="<?= $base_uri ?>/css/main.css" />

	<meta name="twitter:site" content="@dexfolio">
	<meta name="twitter:creator" content="@dexfolioapp">
	<meta name="twitter:title" content="Dexfolio - Try out the Dexfolio App">
	<meta name="twitter:description" content="Try out the Dexfolio App available on IOS Appsotore. Trade to your hearts content.">
	<meta property="og:url" content="https://tools.dexfolio.org/listing-check/" />
	<meta property="og:title" content="Dexfolio - Try out the Dexfolio App" />
	<meta property="og:description" content="Try out the Dexfolio App available on IOS Appsotore. Trade to your hearts content." />

</head>

<body>
	<div class="loader">
		<div class="load-blur"></div>
		<div class="lds-dual-ring"></div>
	</div>
	<div class="container">
		<div class="column">
			<section class="contract-check">
				<div class="nav">
					<a href="https://dexfolio.org" target="_blank" class="logo"></a>
				</div>
				<h1>Is your token listed on the Dexfolio App?</h1>
				<p>
					Dexfolio can supports many Ethereum, BSC, and Polygon tokens!
					<br /><br />
					Tell us the contract address and we’ll check if it’s supported!
				</p>
				<input id="contract-address" class="txt-input" type="text" value="" placeholder="Contract Address" />
				<!-- 0x15Eabb7500E44B7Fdb6e4051cA8DecA430cF9FB8 -->
				<input id="btn-check" class="btn" type="button" value="CHECK!" />
			</section>
			<section class="contract-results hidden">
				<div class="nav">
					<a href="https://dexfolio.org" target="_blank" class="logo"></a>
				</div>
				<div class="back">&#5130; Back</div>
				<h1>Congrats! Your token is listed!</h1>
				<div class="result">
					<p>Ticker: <span class="ticker">DEFX</span></p>
					<p>Project Name: <span class="project">Dexfolio</span></p>
					<p>Current Pirce: <span class="price">$0.0153</span></p>
				</div>
				<p>
					Now spread the word by announcing on twitter.
					<br /><br />
					We just need to know a couple things and we’ll generate an awesome graphic.
				</p>
				<div class="customizer">
					<span class="color-picker">
						<label>Color</label>
						<input oninput="set_color()" id="tnc-input" type="text" data-coloris value="#fff" />
					</span>
					<span class="logo-select">
						<label>logo</label>
						<div>
							<div class="logo-placeholder"></div>
						</div>
					</span>
				</div>
				<input id="input-price" class="txt-input" type="number" value="" placeholder="Token’s IDO or launch price" />
				<!-- 0.01 -->
				<input id="btnGenImg" class="btn" type="button" value="GENERATE GRAPHIC" />
			</section>
		</div>
		<div class="column col-2">
			<section>
				<div class="nav"></div>
				<div class="twitter-feed">
					<a class="twitter-timeline" data-theme="dark" data-limit="1" href="https://twitter.com/dexfolioapp?ref_src=twsrc%5Etfw"></a>
				</div>
			</section>
		</div>
	</div>
	<section class="banner">
		<div class="center-frame">
			<img id="banner-image" src="<?= $base_uri ?>/img/image_loading.gif" />
			<div class="tweet-button"></div>
		</div>
		<div class="bg-blur banner-close"></div>
	</section>
	<script src="<?= $base_uri ?>/js/coloris.min.js"></script>
	<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
	<script src="<?= $base_uri ?>/js/tweetjs.js"></script>
	<script>
		//Color Picker setting
		Coloris({
			value: "#fff",
			format: "rgb",
			theme: "dark",
			swatches: [],
			parent: null,
			wrap: true,
			margin: -60, //margin-bottom
			alpha: false,
		});
		$color = "#fff";

		function set_color(e) {
			$color = document.querySelector("#clr-color-value").value;
		}

		// TweetJs.Search("dexfolio", function (data) {
		// 	const twitterFeed = document.querySelector(".twitter-feed");

		// 	if (data.search_metadata.count > 0) {
		// 		let tweet = data.statuses[0];
		// 		twitterFeed.innerHTML = `
		// 		<p>
		// 			<strong>@${tweet.user.screen_name}</strong> just tweeted about Dexfolio!
		// 		</p>
		// 		<div class="tweet">
		// 			<blockquote class="twitter-tweet" data-theme="dark">
		// 				<a
		// 					href="https://twitter.com/Interior/status/${tweet.id_str}?ref_src=twsrc%5Etfw"
		// 				></a>
		// 			</blockquote>
		// 		</div>`;
		// 	}
		// });
		let data = [];
		$btnCheck = document.querySelector("#btn-check");
		$btnBack = document.querySelector(".back");
		$btnGenImg = document.querySelector("#btnGenImg");
		$bannerClose = document.querySelector(".bg-blur");
		$section1 = document.querySelector(".contract-check");
		$section2 = document.querySelector(".contract-results");
		$section3 = document.querySelector(".banner");
		$body = document.querySelector("body");
		$contractAddress = document.querySelector("#contract-address");
		$inputPrice = document.querySelector("#input-price");
		$tncInput = document.querySelector("#tnc-input");
		$bannerImage = document.querySelector("#banner-image");

		$btnCheck.addEventListener("click", async () => {
			if ($contractAddress.value == "") {
				$contractAddress.classList.add("txt-input-invalid");
			} else {
				$btnCheck.classList.add("btn-loading");
				$body.classList.add("loading");
				$btnCheck.disabled = true;

				try {
					data = await fetch_token($contractAddress.value);
					if (data.status) {
						$section1.classList.add("hidden");
						$section2.classList.remove("hidden");
						$btnCheck.disabled = false;
						$contractAddress.classList.remove("txt-input-invalid");

						document.querySelector(".ticker").innerHTML = data.symbol;
						document.querySelector(".project").innerHTML = data.name;
						document.querySelector(".price").innerHTML = data.price;
						document.querySelector(
							".logo-placeholder"
						).style.backgroundImage = "url('" + data.logo_url + "')";
					} else {
						$contractAddress.value = "";
						$contractAddress.placeholder = data.err_message;
						$contractAddress.classList.add("txt-input-invalid");
						$btnCheck.disabled = false;
					}
				} catch (err) {
					console.log(err);
				}
				$body.classList.remove("loading");
			}
		});

		$btnGenImg.addEventListener("click", async () => {
			if ($inputPrice.value == "" || $inputPrice.value < 0) {
				$inputPrice.classList.add("txt-input-invalid");
			} else {
				$body.classList.add("loading");
				$btnGenImg.classList.add("btn-loading");
				$btnGenImg.disabled = true;

				try {
					let percent = (
						((parseFloat(data.price) - parseFloat($inputPrice.value)) /
							parseFloat($inputPrice.value)) *
						100
					).toFixed(2);

					let message =
						data.symbol + " is " + percent + " % up from your cost";

					if (percent < 0) {
						message =
							data.symbol + " is " + percent + " % down from your cost";
					}

					let request =
						"<?= $base_uri ?>/server/?name=" +
						data.symbol +
						"&logo=" +
						data.logo_url +
						"&action=gen_image&msg=" +
						message +
						"&tnc=" +
						$color;

					// request = encodeURI(request);
					let image_data = await generate_image(request);
					if (image_data.status) {
						if (is_mobile()) {
							document.querySelector(".tweet-button").innerHTML = `
							<a
							href="https://twitter.com/intent/tweet?hashtags=Dexfolio,Crypto,Tracker&related=dexfolioapp,Dexfolio&text=%24${data.symbol}%20is%20supported%20on%20%40Dexfolioapp%21%20Track%20your%20holdings%20%26%20get%20price%20alerts%20so%20you%20never%20miss%20the%20pump.%0A%0ASee%20if%20another%20token%27s%20listed%3A%20&url=https://tools.dexfolio.org/listing-check/i/${image_data.image_name}%0A%0ADownload%20👇%0AAndroid%3A%20press.dexfolio.org%2Ftw_launch_play_store%0AiOS%3A%20press.dexfolio.org%2Ftw_launch_app_store%0A%0A&url=https://tools.dexfolio.org/listing-check/i/${image_data.image_name}%0A"
								class="btn"
								target="_blank"
								><span>Tweet</span></a
								>
								`;
						} else {
							document.querySelector(".tweet-button").innerHTML = `
							<a
								href="https://twitter.com/intent/tweet?hashtags=Dexfolio,Crypto,Tracker&related=dexfolioapp,Dexfolio&text=%24${data.symbol}%20is%20supported%20on%20%40Dexfolioapp%21%20Track%20your%20holdings%20%26%20get%20price%20alerts%20so%20you%20never%20miss%20the%20pump.%0A%0ADownload%20👇%0AAndroid%3A%20press.dexfolio.org%2Ftw_launch_play_store%0AiOS%3A%20press.dexfolio.org%2Ftw_launch_app_store%0A%0ASee%20if%20another%20token%27s%20listed%3A%20%20https://tools.dexfolio.org/listing-check/i/${image_data.image_name}%0A&url=https://tools.dexfolio.org/listing-check/i/${image_data.image_name}%0A"
								class="btn"
								target="_blank"
								><span>Tweet</span></a
							>
							`;
						}


						// document.querySelector(".tweet-button").innerHTML = `
						// 	<a
						// 		href="https://twitter.com/intent/tweet?hashtags=Dexfolio,Crypto,Tracker&related=dexfolioapp,Dexfolio&text=%24${data.symbol}%20is%20supported%20on%20%40Dexfolioapp%21%20Track%20your%20holdings%20%26%20get%20price%20alerts%20so%20you%20never%20miss%20the%20pump.%0A%0ASee%20if%20another%20token%27s%20listed%3A%20&url=https://tools.dexfolio.org/listing-check/i/${image_data.image_name}%0A"
						// 		class="btn"
						// 		target="_blank"
						// 		><span>Tweet</span></a
						// 	>
						// 	`;
						$bannerImage.src = "<?= $base_uri ?>/../i/" + image_data.image_name + ".png";

						$body.classList.remove("loading");
						$section3.classList.add("banner-show");
						$body.classList.add("body-constrict");
					} else {
						$contractAddress.value = "";
						$contractAddress.placeholder = data.err_message;
						$contractAddress.classList.add("txt-input-invalid");
						$btnCheck.disabled = false;
					}
				} catch (err) {
					console.log(err);
				}
			}
		});

		$btnBack.addEventListener("click", () => {
			$section1.classList.remove("hidden");
			$section2.classList.add("hidden");
		});
		$bannerClose.addEventListener("click", () => {
			$section3.classList.remove("banner-show");
			$body.classList.remove("body-constrict");
			$btnGenImg.classList.remove("btn-loading");
			$btnGenImg.disabled = false;
		});

		async function fetch_token(contract) {
			return (
				await fetch(
					"<?= $base_uri ?>/server/index.php?action=fetch_contract&contract_address=" + contract
				)
			).json();
		}
		async function generate_image(url) {
			return (await fetch(url)).json();
		}

		function is_mobile() {
			if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
				return true;
			} else {
				return false;
			}
		}
	</script>
	<script type="application/ld+json">
		{
			"@context": "https://schema.org",
			"@type": "WebPage",
			"headline": "How can I add new Crypto Token or Coin on Dexfolio?",
			"url": "https://tools.dexfolio.org/listing_check/",
			"about": [{
					"@type": "thing",
					"name": "tokens",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Security_token",
						"https://www.google.com/search?q=tokens&kgmid=/m/04hhp8"
					]
				},
				{
					"@type": "thing",
					"name": "cryptocurrency",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Cryptocurrency",
						"https://www.google.com/search?q=cryptocurrency&kgmid=/m/012zcng0"
					]
				},
				{
					"@type": "thing",
					"name": "crypto",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Cryptocurrency",
						"https://www.google.com/search?q=crypto&kgmid=/m/012zcng0"
					]
				},
				{
					"@type": "thing",
					"name": "ethereum",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Ethereum",
						"https://www.google.com/search?q=ethereum&kgmid=/m/0108bn2x"
					]
				},
				{
					"@type": "thing",
					"name": "blockchain",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Blockchain",
						"https://www.google.com/search?q=blockchain&kgmid=/m/0138n0j1"
					]
				},
				{
					"@type": "thing",
					"name": "coin",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Coin",
						"https://www.google.com/search?q=coin&kgmid=/m/0242l"
					]
				},
				{
					"@type": "thing",
					"name": "bitcoin",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Bitcoin",
						"https://www.google.com/search?q=bitcoin&kgmid=/m/0135y0by"
					]
				},
				{
					"@type": "thing",
					"name": "investors",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Investor",
						"https://www.google.com/search?q=investors&kgmid=/m/03krjh"
					]
				},
				{
					"@type": "thing",
					"name": "price",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Price",
						"https://www.google.com/search?q=price&kgmid=/m/01d_1l"
					]
				},
				{
					"@type": "thing",
					"name": "protocol",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Communication_protocol",
						"https://www.google.com/search?q=protocol&kgmid=/m/03m84tb"
					]
				},
				{
					"@type": "thing",
					"name": "assets",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Asset",
						"https://www.google.com/search?q=assets&kgmid=/m/0z1j"
					]
				},
				{
					"@type": "thing",
					"name": "eth",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Ethereum",
						"https://www.google.com/search?q=eth&kgmid=/m/0108bn2x"
					]
				},
				{
					"@type": "thing",
					"name": "decentralized",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Decentralization",
						"https://www.google.com/search?q=decentralized&kgmid=/m/0d3bh"
					]
				},
				{
					"@type": "thing",
					"name": "market cap",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Market_capitalization",
						"https://www.google.com/search?q=market+cap&kgmid=/m/0g1vs"
					]
				},
				{
					"@type": "thing",
					"name": "btc",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Bitcoin",
						"https://www.google.com/search?q=btc&kgmid=/m/0135y0by"
					]
				},
				{
					"@type": "thing",
					"name": "investment",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Investment",
						"https://www.google.com/search?q=investment&kgmid=/m/0g_fl"
					]
				},
				{
					"@type": "thing",
					"name": "ticker",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Ticker_symbol",
						"https://www.google.com/search?q=ticker&kgmid=/m/0142_g"
					]
				},
				{
					"@type": "thing",
					"name": "binance",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Finance",
						"https://www.google.com/search?q=binance&kgmid=/m/02_7t"
					]
				},
				{
					"@type": "thing",
					"name": "utility",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Utility",
						"https://www.google.com/search?q=utility&kgmid=/m/0cc73"
					]
				},
				{
					"@type": "thing",
					"name": "coinmarketcap",
					"sameAs": [
						"http://en.wikipedia.org/wiki/CoinMarketCap",
						"https://www.google.com/search?q=coinmarketcap&kgmid="
					]
				},
				{
					"@type": "thing",
					"name": "smart contracts",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Smart_contract",
						"https://www.google.com/search?q=smart+contracts&kgmid=/m/0dvtq_"
					]
				},
				{
					"@type": "thing",
					"name": "ecosystem",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Ecosystem",
						"https://www.google.com/search?q=ecosystem&kgmid=/m/02mhj"
					]
				}
			],

			"mentions": [{
					"@type": "thing",
					"name": "crypto assets",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Cryptocurrency",
						"https://www.google.com/search?q=crypto+assets&kgmid=/m/012zcng0"
					]
				},
				{
					"@type": "thing",
					"name": "blockchain companies",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Blockchain",
						"https://www.google.com/search?q=blockchain+companies&kgmid=/m/0138n0j1"
					]
				},
				{
					"@type": "thing",
					"name": "blockchains",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Blockchain",
						"https://www.google.com/search?q=blockchains&kgmid=/m/0138n0j1"
					]
				},
				{
					"@type": "thing",
					"name": "blockchain technology",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Blockchain",
						"https://www.google.com/search?q=blockchain+technology&kgmid=/m/0138n0j1"
					]
				},
				{
					"@type": "thing",
					"name": "blockchain systems",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Blockchain",
						"https://www.google.com/search?q=blockchain+systems&kgmid=/m/0138n0j1"
					]
				},
				{
					"@type": "thing",
					"name": "crypto token",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Cryptocurrency",
						"https://www.google.com/search?q=crypto+token&kgmid=/m/012zcng0"
					]
				},
				{
					"@type": "thing",
					"name": "altcoins",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Cryptocurrency",
						"https://www.google.com/search?q=altcoins&kgmid=/m/012zcng0"
					]
				},
				{
					"@type": "thing",
					"name": "decentralized finance",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Decentralized_finance",
						"https://www.google.com/search?q=decentralized+finance&kgmid="
					]
				},
				{
					"@type": "thing",
					"name": "initial coin offerings",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Initial_coin_offering",
						"https://www.google.com/search?q=initial+coin+offerings&kgmid="
					]
				},
				{
					"@type": "thing",
					"name": "cryptocurrency's",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Cryptocurrency",
						"https://www.google.com/search?q=cryptocurrency's&kgmid=/m/012zcng0"
					]
				},
				{
					"@type": "thing",
					"name": "cryptos",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Cryptocurrency",
						"https://www.google.com/search?q=cryptos&kgmid=/m/012zcng0"
					]
				},
				{
					"@type": "thing",
					"name": "tokenomics",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Cryptocurrency",
						"https://www.google.com/search?q=tokenomics&kgmid=/m/012zcng0"
					]
				},
				{
					"@type": "thing",
					"name": "siacoin",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Bitcoin",
						"https://www.google.com/search?q=siacoin&kgmid=/m/0135y0by"
					]
				},
				{
					"@type": "thing",
					"name": "stablecoins",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Stablecoin",
						"https://www.google.com/search?q=stablecoins&kgmid="
					]
				},
				{
					"@type": "thing",
					"name": "zilliqa",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Zilliqa",
						"https://www.google.com/search?q=zilliqa&kgmid="
					]
				},
				{
					"@type": "thing",
					"name": "chainlink",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Chainlink",
						"https://www.google.com/search?q=chainlink&kgmid="
					]
				},
				{
					"@type": "thing",
					"name": "proof-of-work",
					"sameAs": [
						"http://en.wikipedia.org/wiki/Proof_of_work",
						"https://www.google.com/search?q=proof-of-work&kgmid=/m/05bdrw"
					]
				}
			]
		}
	</script>
</body>

</html>