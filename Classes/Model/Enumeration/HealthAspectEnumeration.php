<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Enumeration;

use Brotkrueml\Schema\Core\Model\EnumerationInterface;

/**
 * HealthAspectEnumeration enumerates several aspects of health content online, each of which might be described using hasHealthAspect and HealthTopicContent.
 */
enum HealthAspectEnumeration implements EnumerationInterface
{
    /**
     * Content about the allergy-related aspects of a health topic.
     */
    case AllergiesHealthAspect;

    /**
     * Content about the benefits and advantages of usage or utilization of topic.
     */
    case BenefitsHealthAspect;

    /**
     * Information about the causes and main actions that gave rise to the topic.
     */
    case CausesHealthAspect;

    /**
     * Content about contagion mechanisms and contagiousness information over the topic.
     */
    case ContagiousnessHealthAspect;

    /**
     * Content about the effectiveness-related aspects of a health topic.
     */
    case EffectivenessHealthAspect;

    /**
     * Content that discusses practical and policy aspects for getting access to specific kinds of healthcare (e.g. distribution mechanisms for vaccines).
     */
    case GettingAccessHealthAspect;

    /**
     * Content that discusses and explains how a particular health-related topic works, e.g. in terms of mechanisms and underlying science.
     */
    case HowItWorksHealthAspect;

    /**
     * Information about how or where to find a topic. Also may contain location data that can be used for where to look for help if the topic is observed.
     */
    case HowOrWhereHealthAspect;

    /**
     * Content discussing ingredients-related aspects of a health topic.
     */
    case IngredientsHealthAspect;

    /**
     * Information about coping or life related to the topic.
     */
    case LivingWithHealthAspect;

    /**
     * Related topics may be treated by a Topic.
     */
    case MayTreatHealthAspect;

    /**
     * Content about common misconceptions and myths that are related to a topic.
     */
    case MisconceptionsHealthAspect;

    /**
     * Overview of the content. Contains a summarized view of the topic with the most relevant information for an introduction.
     */
    case OverviewHealthAspect;

    /**
     * Content about the real life experience of patients or people that have lived a similar experience about the topic. May be forums, topics, Q-and-A and related material.
     */
    case PatientExperienceHealthAspect;

    /**
     * Content discussing pregnancy-related aspects of a health topic.
     */
    case PregnancyHealthAspect;

    /**
     * Information about actions or measures that can be taken to avoid getting the topic or reaching a critical situation related to the topic.
     */
    case PreventionHealthAspect;

    /**
     * Typical progression and happenings of life course of the topic.
     */
    case PrognosisHealthAspect;

    /**
     * Other prominent or relevant topics tied to the main topic.
     */
    case RelatedTopicsHealthAspect;

    /**
     * Information about the risk factors and possible complications that may follow a topic.
     */
    case RisksOrComplicationsHealthAspect;

    /**
     * Content about the safety-related aspects of a health topic.
     */
    case SafetyHealthAspect;

    /**
     * Content about how to screen or further filter a topic.
     */
    case ScreeningHealthAspect;

    /**
     * Information about questions that may be asked, when to see a professional, measures before seeing a doctor or content about the first consultation.
     */
    case SeeDoctorHealthAspect;

    /**
     * Self care actions or measures that can be taken to sooth, health or avoid a topic. This may be carried at home and can be carried/managed by the person itself.
     */
    case SelfCareHealthAspect;

    /**
     * Side effects that can be observed from the usage of the topic.
     */
    case SideEffectsHealthAspect;

    /**
     * Stages that can be observed from a topic.
     */
    case StagesHealthAspect;

    /**
     * Symptoms or related symptoms of a Topic.
     */
    case SymptomsHealthAspect;

    /**
     * Treatments or related therapies for a Topic.
     */
    case TreatmentsHealthAspect;

    /**
     * Categorization and other types related to a topic.
     */
    case TypesHealthAspect;

    /**
     * Content about how, when, frequency and dosage of a topic.
     */
    case UsageOrScheduleHealthAspect;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
