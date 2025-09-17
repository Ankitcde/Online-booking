document.getElementById('search-btn').addEventListener('click', function() {
    const type = document.getElementById('transport-type').value;
    const from = document.getElementById('from').value;
    const to = document.getElementById('to').value;
    const date = document.getElementById('date').value;

    if (!from || !to || !date) {
        alert('Please fill in all fields');
        return;
    }

    fetch(`booking.php?action=search&type=${type}&from=${from}&to=${to}&date=${date}`)
        .then(response => response.json())
        .then(data => {
            const resultsDiv = document.getElementById('results');
            resultsDiv.innerHTML = '';
            if (data.length === 0) {
                resultsDiv.innerHTML = '<p>No tickets found</p>';
            } else {
                data.forEach(ticket => {
                    const ticketDiv = document.createElement('div');
                    ticketDiv.innerHTML = `
                        <p>${ticket.type} from ${ticket.from_location} to ${ticket.to_location} on ${ticket.date} at ${ticket.time} - $${ticket.price} (${ticket.available_seats} seats available)</p>
                        <button onclick="bookTicket(${ticket.id})">Book</button>
                    `;
                    resultsDiv.appendChild(ticketDiv);
                });
            }
        })
        .catch(error => console.error('Error:', error));
});

function bookTicket(ticketId) {
    fetch('booking.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=book&ticket_id=${ticketId}`
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            // Refresh search or update UI
            document.getElementById('search-btn').click();
        }
    })
    .catch(error => console.error('Error:', error));
}
