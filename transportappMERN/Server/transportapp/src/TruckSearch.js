import React from 'react';
import TruckList from './TruckList';

function TruckSearch({ truckJobs }) {
    return (
        <>
            <h4>Pending Orders:</h4>
            <div data-transport-order="jobfilter">
                <input type="text" id="filtersearch" data-transport-order="SearchField" placeholder="Search for jobs.."></input>
            </div>
            <TruckList 
                truckJobs={truckJobs}
            />
        </>
    )
}

export default TruckSearch
