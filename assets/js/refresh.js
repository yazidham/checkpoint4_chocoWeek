if (document.querySelector('.js-content')) {
    const refreshButton = document.getElementById('refreshButton')
    const refreshIcon = document.getElementById('refreshIcon')
    const content = document.querySelector('.js-content')

// console.log(refreshButton);
    refreshButton.addEventListener('click', refresh)

    async function refresh(event) {
        refreshIcon.classList.add('rotation');
        event.preventDefault()
        let filterLink = event.currentTarget;
        let link = filterLink.href;

        const response = await fetch(link, {
            headers: {
                'X-Requested-with': 'XMLHttpRequest'
            }
        })
        if (response.status >= 200 && response.status < 300) {
            const data = await response.json()
            refreshIcon.classList.remove('rotation');
            content.innerHTML = data.content
        }
    }
}