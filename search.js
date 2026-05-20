const search = document.getElementById('search');
const locationInput = document.getElementById('location');
const areaInput = document.getElementById('area');

if(search) {

    function fetchRestaurants() {

        const q = search.value;
        const location = locationInput.value;
        const area = areaInput.value;

        fetch(`api/search.php?q=${q}&location=${location}&area=${area}`)

        .then(res => res.json())

        .then(data => {

            let html = '';

            data.forEach(item => {

                html += `
                <div class="card">
                    <h3>${item.name}</h3>
                    <p>${item.location}</p>
                    <p>${item.area}</p>

                    <a href="restaurant.php?id=${item.id}">
                        View Restaurant
                    </a>
                </div>
                `;
            });

            document.getElementById('restaurant-list').innerHTML = html;
        });
    }

    search.addEventListener('keyup', fetchRestaurants);
    locationInput.addEventListener('keyup', fetchRestaurants);
    areaInput.addEventListener('keyup', fetchRestaurants);
}