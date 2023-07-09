const form = document.querySelector('#form')

function submit() {
    form.submit()
}

function updateImage(buyer_id) {
    let formData = new FormData()
    formData.append('profile_img', document.querySelector('#profile_img').files[0])
    formData.append('buyer_id', buyer_id)

    fetch('/api/buyer/updateProfileImage', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
        },
        body: formData
    }).then(response => {
        console.log(response)
        response.json().then(data => {
            console.log(data)
            const img = document.querySelector('#img')
            img.src = data.img_url
        })
    }).catch(err => {
        console.log(err)
    })

}

function togglePassword() {
    const password = document.querySelectorAll('.password')
    if (password[0].type === 'password') {
        password[0].type = 'text'
        password[1].type = 'text'
    }
    else {
        password[0].type = 'password'
        password[1].type = 'password'
    }
}