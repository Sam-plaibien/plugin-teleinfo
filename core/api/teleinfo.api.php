<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

global $jsonrpc;
if (!is_object($jsonrpc)) {
	throw new Exception(__('JSONRPC object not defined', __FILE__), -32699);
}
$params = $jsonrpc->getParams();

if ($jsonrpc->getMethod() == 'deamonRunning') {
	$jsonrpc->makeSuccess(teleinfo::deamonRunning());
}

if ($jsonrpc->getMethod() == 'stopDeamon') {
	$jsonrpc->makeSuccess(teleinfo::stopDeamon());
}

if ($jsonrpc->getMethod() == 'restartDeamon') {
	teleinfo::stopDeamon();
	if (teleinfo::deamonRunning()) {
		throw new Exception(__('Impossible d\'arrêter le démon', __FILE__));
	}
	log::clear('teleinfocmd');
	teleinfo::cron();
	$jsonrpc->makeSuccess();
}

throw new Exception(__('Aucune methode correspondante pour le plugin Teleinfo : ' . $jsonrpc->getMethod(), __FILE__));
?>