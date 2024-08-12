document.addEventListener("DOMContentLoaded", function() {
	var sshLinks = document.querySelectorAll(".ewpt-ssh a");
	sshLinks.forEach(function(link) {
		// Add tooltip
		var tooltip = document.createElement("div");
		tooltip.className = "ssh-tooltip";
		link.appendChild(tooltip);
		// Add link copy
		if (link.id === "ssh-icon-copy-link") {
		  link.addEventListener("click", function(event) {
			event.preventDefault();
			var copyDataUrl = link.getAttribute("data-url");
			navigator.clipboard.writeText(copyDataUrl);
			var tooltiptext = document.createElement("span");
			tooltiptext.className = "tooltiptext";
			tooltiptext.innerText = "Link copied";
			// Replace "Link copy" tooltip with "Link copied"
			var originalTooltip = link.querySelector(".tooltiptext");
			var originalTooltipText = originalTooltip.innerText;
			originalTooltip.innerText = tooltiptext.innerText;
			//recaplace old text after 1 seconds
			setTimeout(function() {
			  originalTooltip.innerText = originalTooltipText;
			  tooltip.removeChild(tooltiptext);
			}, 1000);
		  });
		}
		// Add print
		if (link.id === "ssh-icon-print") {
		  link.addEventListener("click", function(event) {
			event.preventDefault();
			window.print();
		  });
		}
	});
});