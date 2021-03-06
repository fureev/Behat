<?php

namespace Behat\Behat\Tester\EventSubscriber;

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Behat\Behat\Event\EventInterface;
use Behat\Behat\Tester\BackgroundTester;
use Behat\Behat\Tester\Event\BackgroundTesterCarrierEvent;
use Behat\Behat\Tester\Event\ExampleTesterCarrierEvent;
use Behat\Behat\Tester\Event\ExerciseTesterCarrierEvent;
use Behat\Behat\Tester\Event\FeatureTesterCarrierEvent;
use Behat\Behat\Tester\Event\ScenarioTesterCarrierEvent;
use Behat\Behat\Tester\Event\StepTesterCarrierEvent;
use Behat\Behat\Tester\Event\SuiteTesterCarrierEvent;
use Behat\Behat\Tester\ExampleTester;
use Behat\Behat\Tester\ExerciseTester;
use Behat\Behat\Tester\FeatureTester;
use Behat\Behat\Tester\OutlineTester;
use Behat\Behat\Tester\ScenarioTester;
use Behat\Behat\Tester\StepTester;
use Behat\Behat\Tester\SuiteTester;
use Behat\Gherkin\Node\OutlineNode;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Tester dispatcher.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class TesterDispatcher implements EventSubscriberInterface
{
    private $exerciseTester;
    private $suiteTester;
    private $featureTester;
    private $backgroundTester;
    private $scenarioTester;
    private $outlineTester;
    private $exampleTester;
    private $stepTester;

    /**
     * Initializes dispatcher.
     *
     * @param ExerciseTester   $exerciseTester
     * @param SuiteTester      $suiteTester
     * @param FeatureTester    $featureTester
     * @param BackgroundTester $backgroundTester
     * @param ScenarioTester   $scenarioTester
     * @param OutlineTester    $outlineTester
     * @param ExampleTester    $exampleTester
     * @param StepTester       $stepTester
     */
    public function __construct(
        ExerciseTester $exerciseTester,
        SuiteTester $suiteTester,
        FeatureTester $featureTester,
        BackgroundTester $backgroundTester,
        ScenarioTester $scenarioTester,
        OutlineTester $outlineTester,
        ExampleTester $exampleTester,
        StepTester $stepTester
    )
    {
        $this->exerciseTester = $exerciseTester;
        $this->suiteTester = $suiteTester;
        $this->featureTester = $featureTester;
        $this->backgroundTester = $backgroundTester;
        $this->scenarioTester = $scenarioTester;
        $this->outlineTester = $outlineTester;
        $this->exampleTester = $exampleTester;
        $this->stepTester = $stepTester;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            EventInterface::CREATE_EXERCISE_TESTER   => array('setExerciseTester', 0),
            EventInterface::CREATE_SUITE_TESTER      => array('setSuiteTester', 0),
            EventInterface::CREATE_FEATURE_TESTER    => array('setFeatureTester', 0),
            EventInterface::CREATE_BACKGROUND_TESTER => array('setBackgroundTester', 0),
            EventInterface::CREATE_SCENARIO_TESTER   => array('setScenarioTester', 0),
            EventInterface::CREATE_EXAMPLE_TESTER    => array('setExampleTester', 0),
            EventInterface::CREATE_STEP_TESTER       => array('setStepTester', 0),
        );
    }

    /**
     * Sets exercise tester to the carrier event.
     *
     * @param ExerciseTesterCarrierEvent $event
     */
    public function setExerciseTester(ExerciseTesterCarrierEvent $event)
    {
        $event->setTester($this->exerciseTester);
    }

    /**
     * Sets suite tester to the carrier event.
     *
     * @param SuiteTesterCarrierEvent $event
     */
    public function setSuiteTester(SuiteTesterCarrierEvent $event)
    {
        $event->setTester($this->suiteTester);
    }

    /**
     * Sets feature tester to the carrier event.
     *
     * @param FeatureTesterCarrierEvent $event
     */
    public function setFeatureTester(FeatureTesterCarrierEvent $event)
    {
        $event->setTester($this->featureTester);
    }

    /**
     * Sets background tester to the carrier event.
     *
     * @param BackgroundTesterCarrierEvent $event
     */
    public function setBackgroundTester(BackgroundTesterCarrierEvent $event)
    {
        $event->setTester($this->backgroundTester);
    }

    /**
     * Sets scenario tester to the carrier event.
     *
     * @param ScenarioTesterCarrierEvent $event
     */
    public function setScenarioTester(ScenarioTesterCarrierEvent $event)
    {
        $tester = $event->getScenario() instanceof OutlineNode ? $this->outlineTester : $this->scenarioTester;

        $event->setTester($tester);
    }

    /**
     * Sets outline example tester to the carrier event.
     *
     * @param ExampleTesterCarrierEvent $event
     */
    public function setExampleTester(ExampleTesterCarrierEvent $event)
    {
        $event->setTester($this->exampleTester);
    }

    /**
     * Sets step tester to the carrier event.
     *
     * @param StepTesterCarrierEvent $event
     */
    public function setStepTester(StepTesterCarrierEvent $event)
    {
        $event->setTester($this->stepTester);
    }
}
