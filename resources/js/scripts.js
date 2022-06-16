const grid_rewards = document.getElementsByClassName('grid-rewards-card')
const code_activities = document.getElementsByClassName('code-activity-card')
const chick_race_activities = document.getElementsByClassName('chick-race-activity-card')

const linkForGrid = function() {
    let grid_id = this.getAttribute("data-grid-rewards-id")
    window.location = app_url + 'anim/grid-rewards/show/' + grid_id
}

for(let i=0; i < grid_rewards.length; i++) {
    grid_rewards[i].addEventListener('click', linkForGrid, false)
}

const linkForCodeActivity = function() {
    let activity_id = this.getAttribute("data-activity-code-id")
    window.location = app_url + 'anim/decode/show/' + activity_id
}

for(let i=0; i < code_activities.length; i++) {
    code_activities[i].addEventListener('click', linkForCodeActivity, false)
}

const linkForChickRaceActivity = function() {
    let activity_id = this.getAttribute("data-activity-chick-race-id")
    window.location = app_url + 'anim/chick-race/show/' + activity_id
}

for(let i=0; i < chick_race_activities.length; i++) {
    chick_race_activities[i].addEventListener('click', linkForChickRaceActivity, false)
}



