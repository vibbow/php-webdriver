<?php
/**
 * Copyright 2017-2020 Anthon Pang. All Rights Reserved.
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
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\Alert class
 *
 * @package WebDriver
 *
 * @method array dismiss() Dismiss Alert
 * @method array accept() Accept Alert
 * @method array getText() Get Alert Text
 * @method array postText() Send Alert Text
 */
final class Alert extends AbstractWebDriver
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return array(
            'dismiss' => array('POST'),
            'accept' => array('POST'),
            'text' => array('GET', 'POST'),
        );
    }
}
