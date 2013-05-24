<div id="exerplan-exercise-[[+exerplan.id]]">
    <div>Exercise: [[+exerplan.name]]</div>
    <div>Description: [[+exerplan.description]]</div>
    <div>Goal: [[+exerplan.goal]]</div>
    <div>Level: [[+exerplan.level_name]]</div>
    <div>Sets: [[+exerplan.set]]</div>
    <div>Reps: [[+exerplan.repetition]]</div>
    [[+exerplan.usergroup:notempty=`
    <div>Usergroup: [[+exerplan.usergroup]]</div>
    `]]
    [[+exerplan.galleries:notempty=`
    [[+exerplan.galleries]]
    `]]
</div>