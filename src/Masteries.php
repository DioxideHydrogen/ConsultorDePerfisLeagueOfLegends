<?php declare(strict_types=1);

namespace ProfessorJamesBach;

class Masteries
{
    /** @var array */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /** @return Champion[] */
    public function getChampions(): array
    {
        return array_map(function (array $data): Champion {
            return new Champion($data);
        }, $this->data);
    }

    public function getIconUrl(int $level): string
    {
        if ($level == 1) {
            return "https://vignette.wikia.nocookie.net/leagueoflegends/images/d/d8/Champion_Mastery_Level_1_Flair.png/revision/latest?cb=20150312005229&format=original";
        } elseif ($level == 2) {
            return "https://vignette.wikia.nocookie.net/leagueoflegends/images/4/4d/Champion_Mastery_Level_2_Flair.png/revision/latest?cb=20150312005244&format=original";
        } elseif ($level == 3) {
            return "https://vignette.wikia.nocookie.net/leagueoflegends/images/e/e5/Champion_Mastery_Level_3_Flair.png/revision/latest?cb=20150312005319&format=original";
        } elseif ($level == 4) {
            return "https://vignette.wikia.nocookie.net/leagueoflegends/images/b/b6/Champion_Mastery_Level_4_Flair.png/revision/latest?cb=20150312005332&format=original";
        } elseif ($level == 5) {
            return "https://vignette.wikia.nocookie.net/leagueoflegends/images/9/96/Champion_Mastery_Level_5_Flair.png/revision/latest?cb=20150312005344&format=original";
        } elseif ($level == 6) {
            return "http://3.bp.blogspot.com/-7w7NStt6ZKU/VdDTcuDov8I/AAAAAAAAAEg/ECHPzWw_GrU/s1600/image%2B183.png";
        } elseif ($level == 7) {
            return "https://4.bp.blogspot.com/-QbNqC_3bGZQ/VypfhMBS2OI/AAAAAAAABjs/BYfPxW9J0IwcZDTxzQ5azlTQYYTvDIo0wCLcB/s1600/maestri%2B7.png";
        }
    }
}