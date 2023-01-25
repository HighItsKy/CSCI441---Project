import React from 'react';
import TruckForm from './TruckForm.js';
import TruckSearch from './TruckSearch.js';

function Content({ truckJobs }) {
    return (
        <main>
            <div className="row">
                <div className="col-md-6">
                    <TruckForm />
                </div>
                <div className="col-md-6">
                    <TruckSearch 
                        truckJobs = {truckJobs}
                    />
                </div>
            </div>
        </main>
    )
}

export default Content
