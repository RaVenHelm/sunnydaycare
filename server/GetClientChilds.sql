SELECT client.firstname AS  'clientFirst', client.lastname AS  'clientLast', client.billpayer, child.firstname AS  'childFirst', child.lastname AS 'childLast'
FROM  `client` AS client
LEFT JOIN  `client_has_child` AS cc ON client.id = cc.Client_id
LEFT JOIN  `child` AS child ON cc.Child_id = child.id
WHERE `cc`.Child_id IS NOT NULL AND client.billpayer = TRUE
ORDER BY clientFirst ASC;