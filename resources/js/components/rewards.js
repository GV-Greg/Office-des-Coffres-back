const grid = document.getElementsByClassName('grid-rewards-card')

const link = function() {
    let id = this.getAttribute("data-id")
    window.location = '/odc-api-back/public/anim/grid-rewards/show-grid/' + id
}

for(let i=0; i < grid.length; i++) {
    grid[i].addEventListener('click', link, false);
}
