let userBox = document.querySelector('.header .flex .account-box');

document.querySelector('#user-btn').onclick = () => {
    userBox.classList.toggle('active');
    navbar.classList.remove('active');
}

let navbar = document.querySelector('.header .flex .navbar');

document.querySelector('#menu-btn').onclick = () => {
    navbar.classList.toggle('active');
    userBox.classList.remove('active');
}

window.onscroll = () => {
    userBox.classList.remove('active');
    navbar.classList.remove('active');
}

function toggleCreditCardFields() {
    var method = document.getElementById("payment-method").value;
    var cardFields = document.getElementById("credit-card-fields");
    if (method === "credit card") {
        cardFields.style.display = "block";
        document.querySelector('input[name="card_number"]').required = true;
        document.querySelector('input[name="expiry_date"]').required = true;
        document.querySelector('input[name="cvv"]').required = true;
    } else {
        cardFields.style.display = "none";
        document.querySelector('input[name="card_number"]').required = false;
        document.querySelector('input[name="expiry_date"]').required = false;
        document.querySelector('input[name="cvv"]').required = false;
    }
}

// Trigger function on page load to handle pre-selected method
window.onload = function () {
    toggleCreditCardFields();
}
document.getElementById('phone-number').addEventListener('input', function () {
    const phoneNumber = this.value;
    const errorMessage = document.getElementById('phone-error');

    // Remove any non-digit characters and limit to 11 digits
    this.value = phoneNumber.replace(/[^0-9]/g, '').slice(0, 11);

    // Display error if length is not 11
    if (this.value.length === 11) {
        errorMessage.style.display = 'none';
    } else {
        errorMessage.style.display = 'block';
    }
});
// Initialize the map centered on Yangon, Myanmar
var map = L.map('map').setView([16.8408, 96.1734], 12);

// Add the Tile Layer (OpenStreetMap)
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
}).addTo(map);

// Define the bounding box for Yangon city
var yangonBounds = [
    [16.736, 96.079],  // Southwest coordinates
    [16.945, 96.267]   // Northeast coordinates
];
var boundsPolygon = L.polygon([
    [16.736, 96.079],
    [16.736, 96.267],
    [16.945, 96.267],
    [16.945, 96.079]
]).addTo(map);

// Restrict the map view to Yangon city
map.setMaxBounds(yangonBounds);
map.on('drag', function() {
    map.panInsideBounds(yangonBounds, { animate: false });
});

// Create a variable to store the marker
var marker;

// Handle clicks on the map
map.on('click', function(e) {
    var latlng = e.latlng;
    if (!boundsPolygon.getBounds().contains(latlng)) {
        alert("No other region except Yangon, Myanmar. Please select an address within Yangon.");
        return; // Prevent further action
    }

    // Display address details on the form
    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latlng.lat}&lon=${latlng.lng}`)
        .then(response => response.json())
        .then(data => {
            var address = data.address;
            document.getElementById('street').value = address.road || '';
            document.getElementById('flat').value = address.house_number || '';
            document.getElementById('city').value = address.city || address.town || address.village || '';

            // Remove existing marker if any
            if (marker) {
                map.removeLayer(marker);
            }
            
            // Add a new marker for the selected address
            marker = L.marker([latlng.lat, latlng.lng]).addTo(map);
            marker.bindPopup("Selected Address:<br>" + address.road + ', ' + address.house_number + ', ' + (address.city || address.town || address.village)).openPopup();
        })
        .catch(error => console.error('Error fetching address:', error));
});

// Initialize the Geocoder
var geocoder = L.Control.Geocoder.nominatim();

// Add event listener to the form submission
document.getElementById('order-form').addEventListener('submit', function(e) {
    var phoneNumber = document.getElementById('phone-number').value;
    if (phoneNumber.length !== 11) {
        e.preventDefault(); // Prevent form submission
        document.getElementById('phone-error').style.display = 'block';
    }
});

// Handle address search in the form
document.getElementById('street').addEventListener('change', function() {
    var address = this.value;
    geocoder.geocode(address, function(results) {
        if (results && results.length > 0) {
            var latlng = results[0].center;
            map.setView(latlng, 15);

            // Remove existing marker if any
            if (marker) {
                map.removeLayer(marker);
            }

            // Add a new marker for the searched address
            marker = L.marker(latlng).addTo(map);
            marker.bindPopup("Searched Address:<br>" + address).openPopup();
        } else {
            alert('Address not found.');
        }
    });
});
