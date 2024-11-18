<?php

require_once(__DIR__ . '/../database/Connection.php');

class RelatoryRepository
{
    public static function getTotalHoursOfFocus($id_list, $id_user)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("
                SELECT round(SUM(t.duracao), 2) AS tempo_foco 
                FROM lista_tarefa lt
                INNER JOIN tarefa t ON lt.id_tarefa = t.id
                INNER JOIN lista l ON lt.id_lista = l.id
                WHERE l.id = ? AND l.id_usuario = ?
            ");
            $stmt->execute([$id_list, $id_user]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception("Erro ao calcular o tempo de foco", 500);
        }
    }

    public static function getCompletedTasksByTypeListInLast7Days($id_user)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("
            SELECT COALESCE(SUM(TIMESTAMPDIFF(HOUR, t.dt_inicio, t.dt_final)), 0) AS total_tempo
            FROM tarefa t
            INNER JOIN lista_tarefa lt ON t.id = lt.id_tarefa
            INNER JOIN lista l ON lt.id_lista = l.id
            WHERE t.status = 'concluída' 
            AND t.dt_final >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            AND l.id_usuario = ?;
        ");
            $stmt->execute([$id_user]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar as tarefas efetuadas", 500);
        }
    }
}