i = 0
d3.json("../data/zombies.json", function(error, data) {
    parser = JSON.stringify(data)
    zombies_data = JSON.parse(parser)
    zombies_list = zombies_data.zombies

    zombies_list.forEach(zombie => {
        i += 1
    });
    count = document.getElementById("zombiescount");
    count.innerHTML = i;
});