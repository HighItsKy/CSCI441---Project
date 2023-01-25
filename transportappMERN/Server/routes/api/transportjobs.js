const express = require('express');
const router = express.Router();
const transportController = require('../../controllers/transportjobController');
const ROLES_LIST = require('../../config/roles_list');
const verifyRoles = require('../../middleware/verifyRoles');

router.route('/')
    .get(transportController.getAllJobs)
    .post(transportController.createNewJob)
    .put(transportController.updateJob)
    .delete(transportController.deleteJob);

router.route('/:Job')
    .get(transportController.getJob);

module.exports = router;