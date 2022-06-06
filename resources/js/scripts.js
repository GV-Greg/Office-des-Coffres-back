const grid_rewards = document.getElementsByClassName('grid-rewards-card')
const activities = document.getElementsByClassName('activity-card')

const linkForGrid = function() {
    let grid_id = this.getAttribute("data-grid-rewards-id")
    window.location = app_url + 'anim/grid-rewards/show-grid/' + grid_id
}

for(let i=0; i < grid_rewards.length; i++) {
    grid_rewards[i].addEventListener('click', linkForGrid, false)
}

const linkForCodeActivity = function() {
    let activity_id = this.getAttribute("data-activity-code-id")
    window.location = app_url + 'anim/decode/show-code-activity/' + activity_id
}

for(let i=0; i < activities.length; i++) {
    activities[i].addEventListener('click', linkForCodeActivity, false)
}

