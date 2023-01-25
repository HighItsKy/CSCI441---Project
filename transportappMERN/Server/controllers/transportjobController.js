const TransportJobs = require("../model/transportjobs.model.js");

const getAllJobs = (req, res) => {
    TransportJobs.getAll((err, data) => {
        if (err)
            res.status(500).send({
                message:
                    err.message ||
                    "Some error occurred while retrieving properties."
            });
        else res.send(data);
    });
};

const createNewJob = (req, res) => {
    // Validate request
    if (!req.body) {
        res.status(400).send({
            message: "Content cannot be empty!"
        });
    }
    // Create a Property
    const transportJob = new TransportJobs(req.body);
    TransportJobs.create(transportJob, (err, data) => {
        if (err)
            res.status(500).send({
                message:
                    err.message ||
                    "Some error occurred while creating the job."
            });
        else res.send(data);
    });
};

const updateJob = (req, res) => {
    // Validate Request
    if (!req.body) {
        res.status(400).send({
            message: "Content can not be empty!"
        });
    }

    TransportJobs.updateById(new TransportJobs(req.body), (err, data) => {
        if (err) {
            if (err.kind === "not_found") {
                res.status(404).send({
                    message: `Not found Job with id ${req.body.ID}.`
                });
            } else {
                res.status(500).send({
                    message: `Error updating Job with id ${req.body.ID}`
                });
            }
        } else res.send(data);
    });
};

const deleteJob = (req, res) => {
    res.status(404).send({ message: "Not Implemented" });
};

const getJob = (req, res) => {
    TransportJobs.findById(req.params.Job, (err, data) => {
        if (err) {
            if (err.kind === "not_found") {
                res.status(404).send({
                    message: `Not found Property with id ${req.params.ID}.`
                });
            } else {
                res.status(500).send({
                    message: "Error retrieving Property with id " + req.params.ID
                });
            }
        } else res.send(data);
    });
};

module.exports = {
    getAllJobs,
    createNewJob,
    updateJob,
    deleteJob,
    getJob,
};
