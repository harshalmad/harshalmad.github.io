<?php include 'header.php'; ?>

  <!-- Page content goes here -->
  <div class="container mt-4">
    <h2>Create order</h2>
    <p>Fill out the following information to complete your order:</p>
		<p>Note: you must register for an ID before you can place an order.</p>

	<form action="createorder_submit.php" method="POST" id="myForm" onsubmit="return calculateTotalPrice()">
  
	<p>
		<label for="id">Enter your User ID:</label>
		<input type="text" id="id" name="id" required>
	</p>

	<p>
		<label for="drinktype">Choose a type of drink:</label>
		<select id="drinktype" name="drinktype" required>
			<option value="soda" data-price="0.20">Soda ($0.20/oz)</option>
			<option value="tea" data-price="0.25">Tea ($0.25/oz)</option>
			<option value="fruit punch" data-price="0.30">Fruit Punch ($0.30/oz)</option>
		</select>
	</p>
	
	<p>
		<label for="size">Choose drink size:</label>
		<select id="size" name="size" required>
			<option value="S" data-ounces="12">Small (12 oz)</option>
			<option value="M" data-ounces="16">Medium (16 oz)</option>
			<option value="L" data-ounces="20">Large (20 oz)</option>
		</select>
	</p>
	
	<p>
		<label for="graphics">Include custom graphics on cup? (May affect cost of order)</label>
		<input type="radio" id="yes" name="graphics" value="" data-price-small="0.54" data-price-medium="0.78" data-price-large="1.16">
		<label for="html">Y</label>
		<input type="radio" id="no" name="graphics" value="" data-price="0" checked />
		<label for="css">N</label><br>
	</p>

  <p>
		<label for="quantity">Enter quantity:</label>
		<input type="number" id="quantity" name="quantity" min="1" pattern="\d*" required>
	</p>

	<input type="hidden" id="totalPrice" name="totalPrice" value="">
	
	<input type="submit" value="Submit Order" name="submitorder">
	</form>
  </div>

  <script>
    function calculateTotalPrice() {
      var drinkTypeSelect = document.getElementById('drinktype');
      var sizeSelect = document.getElementById('size');
      var graphicsYes = document.getElementById('yes');
      var totalPriceInput = document.getElementById('totalPrice');

      var selectedDrinkType = drinkTypeSelect.options[drinkTypeSelect.selectedIndex];
      var selectedSize = sizeSelect.options[sizeSelect.selectedIndex];
      var isGraphicsSelected = graphicsYes.checked;

      var basePrice = parseFloat(selectedDrinkType.getAttribute('data-price'));
      var ounces = parseFloat(selectedSize.getAttribute('data-ounces'));

      var additionalGraphicsPrice = 0;

      var quantity = document.getElementById('quantity');

      if (isGraphicsSelected) {
        var size = sizeSelect.value;

        if (size === 'S') {
          additionalGraphicsPrice = parseFloat(graphicsYes.getAttribute('data-price-small'));
        } else if (size === 'M') {
          additionalGraphicsPrice = parseFloat(graphicsYes.getAttribute('data-price-medium'));
        } else if (size === 'L') {
          additionalGraphicsPrice = parseFloat(graphicsYes.getAttribute('data-price-large'));
        }
      }

      var totalPrice = (basePrice * ounces + additionalGraphicsPrice) * parseFloat(quantity.value);
      totalPriceInput.value = totalPrice.toFixed(2);

      return confirm('Confirm Order\n\nTotal Price: $' + totalPrice.toFixed(2));
    }
  </script>

<?php include 'footer.php'; ?>