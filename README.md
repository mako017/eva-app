# EvaApp

## Table of contents

- [General info](#general-info)
- [Technologies](#technologies)
- [Features](#features)
- [Status](#status)
- [Contact](#contact)

## General info

Evaluations are one of the most important scientific methods in order to assess and consequently improve the quality of products, interventions, and studies. One very prominent type of evaluation is the evaluation of university classes. Oftentime, students are asked to fill out a questionnaire at the end of a term and to evaluate the course and the lecturere. However, in certain cases, such as human medicine, classes are randomly taught by a single lecturer. Oftentimes, each session is taught by an expert and thus evaluations at the end of the whole term lack information.

To solve this problem, the Saarland University Medical Center used the Evabox, a device resembling the feedback stations at airports where you can signal your happiness with a single button press. With this device -and in combination with traditional questionnaires at the end of a term- it became possible to receive detailed feedback for each lecturer. However, with the need for digital courses due to the Covid pandemic, the Evabox couldn't be used any longer. It was thus decided, to develop a digital solution.

This software combines the evaluation interface as well as a backend that facilitates the administration and reporting of evaluations.

## Technologies

This project is created with:

- Vue.js
- Axios
- PHP
- MySQL

## Features

### Implemented

- Evaluation interface
- Fraud prevention (i.e. blocking of repeated evaluations from the same device)
- Basic CMS for the administration of evaluations
- Generation of links and QR codes
- Export of raw data and diagrams in admin area
- Optional end links
- Feedback when changing sessions
- Live feedback

### Planned

- Automatic backups
- Export of reports
- Room planner

### Problems

- Sessions can be deleted even if data exist
- Needs better test to check if sending results is okay

## Status

The project is under development and hasn't been tested yet. First evaluations are planned for the winter term 2020/21.

## Contact

Created by [Marco Koch](mailto:marco.koch@uni-saarland.de?subject=[GitHub]%20EvaApp)
