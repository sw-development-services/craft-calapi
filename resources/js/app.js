
let createBooking = document.getElementById('add_booking');
createBooking.addEventListener('click', function () {
   // open the form
    var frmDiv = document.getElementById('new_booking_fields');
    var classes = frmDiv.classList;
    // remove the hidden class
    frmDiv.classList.toggle('hidden');
});


const getSessionInfo = function() {
    return fetch('/actions/users/session-info', {
        headers: {
            'Accept': 'application/json',
        },
    })
    .then(response => response.json());
};

const eventType = document.getElementById('event_type');
// const form = document.getElementById('new_booking');

eventType.addEventListener('change', function (e) {
    const request = new XMLHttpRequest();
    // const csrf = document.getElementsByName('CRAFT_CSRF_TOKEN');
    const csrfToken = document.querySelector('input[name="CRAFT_CSRF_TOKEN"]').value;

    e.preventDefault();
    const formData = new FormData();
    
    // console.log(csrf[1]['defaultValue']);
    request.open('POST', '/calapi/get-event-data');
    request.setRequestHeader('Content-type', 'application/json');
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.setRequestHeader('X-CSRF-Token', csrfToken);

    formData.append('event_id', e.target.value);

    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                const obj = JSON.parse(request.responseText);
                // console.log(obj.response.link);
                let link = obj.response.link;
                // parse link
                link = link.substr(16);
                const elem = document.getElementById('schedule');

                elem.setAttribute("data-cal-link", link);
                // elem.setAttribute("data-cal-link", link);

                // ...
            } else {
                console.log(`Error ${request.status}: ${request.statusText}`);
            }
        }
    };
    
    request.send(JSON.stringify({'event_id':e.target.value}) );

    request.onerror = function() {
        console.log('request failed');
    }; 
    

});

  

