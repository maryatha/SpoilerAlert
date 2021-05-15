import React from 'react'



const FoodCard = (props) => {
    return (
        <div className="ui card">
            <div className="content">
                <div className="header">{props.name}</div>
                <div className="meta">{props.minute + " minutes"}</div>
                <div className="description">
                    {props.description}
                </div>
            </div>
            <div className="extra content">
                <span className="left floated like">
                    Author: {props.contributor_id}
                </span>
                <span className="right floated star">
                    Time: {props.submitted}
                </span>
            </div>
        </div>
    );
}

export default FoodCard;