const contacts = document.getElementById('contact-table');

if (contacts) {
  contacts.addEventListener('click', e => {
    if (e.target.className === 'btn btn-danger btn-rounded btn-sm my-0 delete-contact') {
      if (confirm('Are you sure?')) {
        const id = e.target.getAttribute('data-id');

        fetch(`/contact/delete/${id}`, {
          method: 'DELETE'
        }).then(res => window.location.reload());
      }
    }
  });
}