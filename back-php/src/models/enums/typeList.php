<?php
enum TypeList: string {
    case Personal = 'pessoal';
    case Work = 'trabalho';
    case Study = 'estudo';
    case Others = 'outros';

    public static function fromId(int $id): ?TypeList {
        return match ($id) {
            1 => self::Personal,
            2 => self::Work,
            3 => self::Study,
            4 => self::Others,
            default => null,
        };
    }
}
?>
