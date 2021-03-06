<?php
/**
 * Copyright 2004-2020 Facebook. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package WebDriver
 *
 * @author Justin Bishop <jubishop@gmail.com>
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver class
 *
 * @package WebDriver
 *
 * @method status
 */
class WebDriver extends AbstractWebDriver implements WebDriverInterface
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return array(
            'status' => 'GET',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function session($requiredCapabilities = Browser::FIREFOX, $desiredCapabilities = array())
    {
        // for backwards compatibility when the only required capability was browser name
        if (! is_array($requiredCapabilities)) {
            $desiredCapabilities[Capability::BROWSER_NAME] = $requiredCapabilities ?: Browser::FIREFOX;

            $requiredCapabilities = array();
        }

        // required
        $parameters = array(
            'desiredCapabilities' => array_merge($desiredCapabilities, $requiredCapabilities)
        );

        // optional
        if (! empty($requiredCapabilities)) {
            $parameters['requiredCapabilities'] = $requiredCapabilities;
        }

        $result = $this->curl(
            'POST',
            '/session',
            $parameters,
            array(CURLOPT_FOLLOWLOCATION => true)
        );

        $capabilities = isset($result['value']['capabilities']) ? $result['value']['capabilities'] : null;
        $this->w3c    = !! $capabilities;

        $session = new Session($result['sessionUrl'], $this->w3c);
        $session->setCapabilities($capabilities);

        return $session;
    }

    /**
     * {@inheritdoc}
     */
    public function sessions()
    {
        $result   = $this->curl('GET', '/sessions');
        $sessions = array();

        // @todo initialize $this->w3c if sessions() is called before session()
        foreach ($result['value'] as $session) {
            $sessions[] = new Session($this->url . '/session/' . $session['id'], $this->w3c);
        }

        return $sessions;
    }
}
