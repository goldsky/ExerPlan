<div
    id="exerplan-assessment-item-[[+exerplan.assessment.id]]"
    [[+exerplan.assessment.row_index:mod:is=`0`:then=`
    style="border-top: 1px dotted #ddd; border-bottom: 1px dotted #ddd; background-color: #ddd; padding: 10px;"
    `:else=`
    style="border-top: 1px dotted #ddd; border-bottom: 1px dotted #ddd; background-color: #efefef;padding: 10px;"
    `]]
    >
    <div
        style="font-style: italic; font-size: smaller; color: grey;"
        >By: [[+exerplan.assessment.assessor.fullname:notempty=`
        [[+exerplan.assessment.assessor.fullname]]
        `:default=`
        [[+exerplan.assessment.assessor.username]]
        `]], [[+exerplan.assessment.created_on:date=`%d-%m-%Y`]]
    </div>
    <div>[[+exerplan.assessment.assessment]]</div>
</div>