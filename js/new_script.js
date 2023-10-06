// Add an event listener to the edit button
document.addEventListener('click', function(e) {
  if (e.target && e.target.classList.contains('edit-btn')) {
    const row = e.target.parentNode.parentNode;
    const id = row.querySelector('td:nth-child(1)').textContent;
    const firstName = row.querySelector('td:nth-child(2) input').value;
    const lastName = row.querySelector('td:nth-child(3) input').value;
    const email = row.querySelector('td:nth-child(4) input').value;

    // Send an AJAX request to update the database
    const xhr = new XMLHttpRequest();
    const url = 'update.php';
    const params = 'id=' + encodeURIComponent(id) +
                   '&firstName=' + encodeURIComponent(firstName) +
                   '&lastName=' + encodeURIComponent(lastName) +
                   '&email=' + encodeURIComponent(email);
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Update the row in the table
        row.querySelector('td:nth-child(2)').innerHTML = firstName;
        row.querySelector('td:nth-child(3)').innerHTML = lastName;
        row.querySelector('td:nth-child(4)').innerHTML = email;
        row.querySelector('.save-btn').style.display = 'none';
        row.querySelector('.edit-btn').style.display = 'inline-block';
      }
    };
    xhr.send(params);
  }
});