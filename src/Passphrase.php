<?php

namespace PassGen;

use PassGen\Interfaces\PassphraseInterface;
use PassGen\Interfaces\RandomInterface;
use PassGen\Random\OpenSSLRandom;
use PassGen\Random\OSRandom;

/**
 * Passphrase Class.
 */
class Passphrase implements PassphraseInterface
{
    /**
     * @var bool capital first letter of each word
     */
    protected bool $capital = false;

    /**
     * @var bool include numbers
     */
    protected bool $numbers = false;

    /**
     * @var string words separator
     */
    protected string $separator = '-';

    /**
     * @var array<string> excludes characters
     */
    protected array $excludes = [];

    /**
     * @var int words count
     */
    protected int $count = 5;

    /**
     * @var RandomInterface $random
     */
    protected RandomInterface $random;

    /**
     * Set random numbers generator.
     *
     * @param RandomInterface $generator
     * @return void
     */
    public function setRandomGenerator(RandomInterface $generator): void
    {
        $this->random = $generator;
    }

    /**
     * Get random number generator.
     *
     * @return RandomInterface
     */
    public function getRandomGenerator(): RandomInterface
    {
        return empty($this->random) ?
            (
                extension_loaded('openssl') ?
                    (new OpenSSLRandom()) :
                    (new OSRandom())
            )
            :
            $this->random;
    }

    /**
     * Capitalize words.
     *
     * @return $this
     */
    public function capitalize(): object
    {
        $this->capital = true;

        return $this;
    }

    /**
     * Set words separator.
     *
     * @param string $separator
     * @return $this
     */
    public function setSeparator(string $separator): object
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * Add numbers.
     *
     * @return $this
     */
    public function withNumbers(): object
    {
        $this->numbers = true;

        return $this;
    }

    /**
     * Exclude specific words.
     *
     * @param array<string> $words
     * @return $this
     */
    public function exclude(array $words): object
    {
        $this->excludes = $words;

        return $this;
    }

    /**
     * Set number of words.
     *
     * @param int $n
     * @return $this
     */
    public function words(int $n): object
    {
        if ($n < 1) {
            throw new \InvalidArgumentException(
                $this::class .
                ': number of words for a passphrase can\'t be less than 1'
            );
        }

        $this->count = $n;

        return $this;
    }

    /**
     * Create the password.
     *
     * @return string
     */
    public function create(): string
    {
        $passphrase = '';
        $word = '';

        for ($i = 0;$i < $this->count;$i++) {
            // handle exclusion
            do {
                $word = $this->words[
                    $this->getRandomGenerator()
                        ->generate(0, count($this->words) - 1)
                ];
            } while (in_array($word, $this->excludes));

            // handle capitalization
            if ($this->capital) {
                $word = ucfirst($word);
            }

            // handle numbers
            if ($this->numbers) {
                $word = $word . $this->getRandomGenerator()->generate(0, 9);
            }

            $passphrase .= $word . $this->separator;
        }

        return rtrim($passphrase, $this->separator);
    }

    /**
     * @var array<string> list of ~2000 most common english words
     */
    protected $words = [
        'arrival', 'manage', 'today', 'wins', 'cheese', 'between', 'gently',
        'country', 'lady', 'cried', 'leave', 'stem', 'drew', 'proper', 'new',
        'sigh', 'million', 'roots', 'houses', 'tale', 'lines', 'accent', 'menu',
        'hire', 'pump', 'times', 'hair', 'hired', 'cinema', 'turns', 'behind',
        'century', 'dull', 'club', 'head', 'tall', 'wings', 'phone', 'soft',
        'angles', 'mice', 'man', 'career', 'four', 'wish', 'crew', 'combine',
        'blood', 'cotton', 'garage', 'piece', 'bent', 'enable', 'island',
        'stupid', 'troops', 'tail', 'broke', 'spot', 'raw', 'turn', 'sticky',
        'fears', 'pillar', 'cup', 'latest', 'crack', 'show', 'agency', 'toward',
        'sure', 'data', 'burn', 'rail', 'mark', 'mud', 'wake', 'weigh',
        'approve', 'making', 'village', 'journey', 'cattle', 'verb', 'sixty',
        'though', 'temper', 'injury', 'spirit', 'office', 'grand', 'thought',
        'figs', 'put', 'smart', 'nurse', 'pack', 'volume', 'truck', 'taxes',
        'urge', 'luck', 'expert', 'middle', 'lakes', 'that', 'herd', 'loads',
        'rows', 'roof', 'reform', 'wrote', 'which', 'joint', 'solar', 'observe',
        'sugar', 'emerge', 'control', 'firm', 'father', 'now', 'wise', 'go',
        'lots', 'few', 'member', 'amount', 'off', 'screen', 'admit', 'port',
        'defense', 'confuse', 'has', 'cross', 'active', 'council', 'route',
        'patient', 'cards', 'eastern', 'echo', 'men', 'tray', 'summer', 'dust',
        'support', 'block', 'handle', 'smooth', 'hours', 'test', 'pet', 'joy',
        'bare', 'ways', 'mean', 'rod', 'infant', 'pause', 'seas', 'rest',
        'haste', 'tribe', 'newly', 'jelly', 'union', 'engine', 'strict', 'cry',
        'grey', 'spicy', 'shower', 'add', 'copper', 'cats', 'inner', 'degrees',
        'hundred', 'author', 'larger', 'party', 'stays', 'guilty', 'travel',
        'chess', 'expect', 'split', 'worm', 'beef', 'pair', 'shield', 'digital',
        'charm', 'badly', 'brain', 'century', 'company', 'level', 'compete',
        'vote', 'tight', 'quit', 'knight', 'pitch', 'ours', 'system', 'odds',
        'steady', 'demand', 'sheep', 'debate', 'king', 'judge', 'fly', 'awake',
        'later', 'season', 'then', 'woke', 'drill', 'poster', 'star', 'log',
        'bit', 'units', 'affect', 'purse', 'foods', 'gas', 'vague', 'skirt',
        'war', 'fair', 'late', 'lands', 'cold', 'clever', 'taught', 'country',
        'climb', 'july', 'sorry', 'lose', 'poor', 'some', 'shape', 'examine',
        'develop', 'conquer', 'cell', 'begin', 'shadow', 'raised', 'join',
        'advise', 'locate', 'hen', 'period', 'student', 'export', 'same',
        'ears', 'number', 'nest', 'train', 'island', 'lawyer', 'buy', 'spend',
        'slice', 'blind', 'maiden', 'using', 'blown', 'dusty', 'food', 'nearby',
        'cars', 'arrange', 'labour', 'shot', 'flags', 'lame', 'select', 'tools',
        'remark', 'virus', 'forward', 'popular', 'pray', 'fame', 'week', 'win',
        'complex', 'strike', 'oven', 'gifts', 'beyond', 'boys', 'commit',
        'agreed', 'not', 'looks', 'muscle', 'pile', 'gate', 'inches', 'bar',
        'urgent', 'remove', 'boxes', 'output', 'sake', 'occur', 'minds',
        'proud', 'money', 'ton', 'sober', 'ugly', 'sites', 'top', 'manager',
        'signed', 'loose', 'weapon', 'choice', 'average', 'yet', 'alone', 'rub',
        'lost', 'short', 'leg', 'far', 'trail', 'maybe', 'able', 'net', 'horn',
        'knows', 'are', 'write', 'socks', 'natural', 'gather', 'collect',
        'clergy', 'mount', 'click', 'advice', 'chosen', 'sudden', 'group',
        'faith', 'bread', 'lastly', 'complain', 'bed', 'enter', 'pretty',
        'theme', 'such', 'clean', 'sphere', 'went', 'hate', 'bedroom', 'shore',
        'those', 'lesson', 'cover', 'cage', 'seeds', 'than', 'intact', 'tongue',
        'beside', 'lips', 'place', 'inform', 'drawing', 'was', 'luxury',
        'chapter', 'type', 'surface', 'employ', 'pets', 'down', 'an', 'equal',
        'kept', 'ink', 'failed', 'wonder', 'address', 'name', 'upward',
        'church', 'damp', 'wash', 'starts', 'drove', 'burns', 'spoon', 'flesh',
        'elder', 'donkey', 'coach', 'thrown', 'who', 'knee', 'console', 'aside',
        'night', 'arm', 'wood', 'smile', 'tent', 'for', 'snow', 'royal',
        'shift', 'holy', 'sum', 'joke', 'chamber', 'mood', 'program', 'nicely',
        'do', 'noon', 'rival', 'force', 'quite', 'falls', 'lend', 'one',
        'comfort', 'design', 'salary', 'butter', 'loop', 'violin', 'empire',
        'freedom', 'actor', 'bill', 'bath', 'clause', 'see', 'pound', 'speed',
        'noble', 'strip', 'measure', 'trash', 'legs', 'balls', 'master',
        'further', 'borrow', 'beds', 'every', 'weary', 'laws', 'colour',
        'treat', 'afraid', 'is', 'where', 'grant', 'idle', 'bridge', 'phrase',
        'golden', 'injure', 'growth', 'just', 'host', 'ship', 'bring', 'time',
        'machine', 'source', 'topic', 'tie', 'die', 'brass', 'line', 'plant',
        'guys', 'answer', 'wages', 'matter', 'pink', 'grass', 'rare', 'victim',
        'recent', 'seat', 'gates', 'goal', 'concrete', 'favour', 'surely',
        'modest', 'neat', 'steep', 'road', 'act', 'insult', 'wander', 'winner',
        'fabric', 'survey', 'voice', 'quick', 'cool', 'postal', 'miles',
        'sales', 'midst', 'piano', 'faint', 'away', 'ill', 'total', 'wallet',
        'film', 'angel', 'used', 'pond', 'custom', 'wax', 'plot', 'room',
        'exactly', 'sight', 'wait', 'alcohol', 'park', 'sold', 'state',
        'prepare', 'leaf', 'lucky', 'tile', 'afford', 'itself', 'equally',
        'these', 'busy', 'mail', 'rains', 'English', 'reader', 'flower',
        'tasks', 'lawn', 'process', 'heart', 'farms', 'crime', 'toe', 'inch',
        'repair', 'she', 'give', 'budget', 'shoes', 'naked', 'potato', 'reduce',
        'account', 'lived', 'bears', 'caps', 'why', 'silly', 'job', 'pull',
        'useful', 'picture', 'facing', 'tops', 'son', 'sick', 'buck', 'lock',
        'twin', 'warm', 'avoid', 'mining', 'god', 'breathe', 'seen', 'lemon',
        'certain', 'tense', 'cheek', 'shop', 'over', 'fierce', 'match',
        'armies', 'learn', 'rescue', 'banks', 'account', 'wrist', 'nation',
        'spell', 'voter', 'comb', 'agree', 'trade', 'fed', 'waves', 'stormy',
        'others', 'rope', 'eyes', 'true', 'feed', 'spoken', 'sorrow', 'taste',
        'much', 'harm', 'hardly', 'mixed', 'left', 'said', 'kitchen', 'adjust',
        'flight', 'areas', 'balance', 'six', 'declare', 'dated', 'basic',
        'anger', 'boxing', 'box', 'believe', 'bat', 'facts', 'coffee', 'point',
        'am', 'usually', 'consult', 'shortly', 'achieve', 'bottom', 'capable',
        'rabbit', 'quarter', 'fade', 'prompt', 'giving', 'cheeks', 'cycle',
        'himself', 'pardon', 'lift', 'review', 'fun', 'chairs', 'clothes',
        'met', 'control', 'defeat', 'as', 'me', 'hook', 'either', 'confess',
        'more', 'begins', 'knife', 'accept', 'pan', 'yellow', 'own', 'parent',
        'most', 'whip', 'find', 'file', 'slim', 'heaven', 'flood', 'old',
        'edges', 'fur', 'throw', 'each', 'wheat', 'gold', 'else', 'if', 'odd',
        'chin', 'too', 'trip', 'ancient', 'shoe', 'relieve', 'energy',
        'already', 'follow', 'debt', 'pop', 'effort', 'limit', 'decent', 'run',
        'margin', 'owner', 'ahead', 'flour', 'tax', 'allow', 'wound', 'command',
        'foreign', 'leaves', 'bureau', 'girls', 'poison', 'feature', 'lamp',
        'marine', 'pierce', 'chair', 'next', 'thirst', 'crowded', 'very',
        'hunt', 'extent', 'meal', 'because', 'well', 'officer', 'forces',
        'hammer', 'lord', 'holds', 'attach', 'knees', 'prize', 'poems', 'cap',
        'saving', 'lonely', 'airport', 'five', 'bullet', 'save', 'grain',
        'ruin', 'called', 'fires', 'mostly', 'beach', 'refer', 'buyer',
        'deliver', 'careful', 'subject', 'scarce', 'your', 'spare', 'human',
        'jump', 'major', 'early', 'tap', 'throat', 'penny', 'flow', 'farmer',
        'us', 'highly', 'utter', 'credit', 'range', 'laugh', 'bonnet', 'health',
        'teacher', 'bucket', 'gravel', 'pot', 'since', 'witch', 'resist',
        'guard', 'face', 'visit', 'fit', 'crazy', 'bite', 'seek', 'sunny',
        'knock', 'fried', 'holiday', 'pure', 'bakery', 'chest', 'like', 'goods',
        'classy', 'pillow', 'were', 'local', 'satisfy', 'main', 'straw',
        'damage', 'decided', 'having', 'and', 'game', 'again', 'had', 'done',
        'annual', 'dress', 'fire', 'worth', 'mixture', 'hence', 'pipes',
        'apart', 'style', 'bind', 'rings', 'glass', 'pour', 'remind', 'flag',
        'defend', 'fault', 'permit', 'square', 'minute', 'seats', 'poetry',
        'hole', 'whole', 'counter', 'series', 'police', 'art', 'twice', 'brave',
        'prayer', 'will', 'swamp', 'entry', 'dollar', 'direct', 'we', 'adopted',
        'autumn', 'instead', 'him', 'count', 'likely', 'risen', 'studio',
        'invest', 'boil', 'madam', 'slowly', 'vocal', 'humour', 'miss', 'alive',
        'mill', 'tennis', 'trend', 'edition', 'torn', 'fruit', 'hello', 'great',
        'merry', 'stage', 'get', 'loan', 'cities', 'hairs', 'breast', 'shade',
        'sad', 'part', 'drop', 'pipe', 'under', 'nature', 'bank', 'runs',
        'desert', 'took', 'cause', 'crisis', 'rocks', 'forty', 'legend',
        'liquid', 'shirt', 'know', 'rise', 'leader', 'serious', 'behalf',
        'tree', 'bush', 'earlier', 'move', 'rider', 'heat', 'placed', 'south',
        'escaped', 'link', 'ticket', 'rice', 'central', 'joined', 'friend',
        'section', 'love', 'shops', 'rule', 'policy', 'insect', 'weather',
        'above', 'end', 'air', 'priest', 'flying', 'content', 'alike', 'depth',
        'day', 'paid', 'ran', 'hurry', 'dates', 'feels', 'fear', 'doors',
        'tiny', 'silent', 'window', 'rely', 'gift', 'slip', 'plots', 'county',
        'salt', 'high', 'lamb', 'online', 'fuel', 'glory', 'barely', 'evening',
        'virtue', 'enjoy', 'print', 'machine', 'drunk', 'meant', 'eleven',
        'effect', 'network', 'depart', 'foot', 'corner', 'price', 'world',
        'appears', 'fresh', 'clock', 'pocket', 'movie', 'reply', 'mayor',
        'hall', 'thee', 'could', 'arise', 'deer', 'explain', 'cooker', 'did',
        'realize', 'guess', 'bell', 'wealth', 'teeth', 'option', 'rank',
        'against', 'ant', 'cloth', 'search', 'small', 'tears', 'duty', 'almost',
        'term', 'sink', 'marks', 'other', 'dry', 'wear', 'final', 'lying',
        'thirty', 'sell', 'nail', 'pig', 'steal', 'cleans', 'calls', 'doctor',
        'slight', 'foul', 'heads', 'female', 'general', 'false', 'origin',
        'truth', 'urban', 'share', 'slow', 'by', 'player', 'cabin', 'cent',
        'seal', 'honey', 'ladder', 'fixed', 'course', 'race', 'seize', 'shall',
        'trim', 'notice', 'ocean', 'courage', 'front', 'wonder', 'guest',
        'here', 'pin', 'branch', 'hang', 'impact', 'cruel', 'relax', 'band',
        'fashion', 'saint', 'across', 'fan', 'town', 'curly', 'grace', 'camera',
        'order', 'wife', 'global', 'song', 'brief', 'thanks', 'famous',
        'reject', 'parcel', 'even', 'disease', 'soap', 'clear', 'gain', 'idea',
        'humble', 'fine', 'fat', 'easy', 'mayo', 'dark', 'goes', 'sense',
        'already', 'kiss', 'bloody', 'page', 'attack', 'open', 'living', 'all',
        'coat', 'consult', 'fact', 'culture', 'bake', 'need', 'granted', 'view',
        'fast', 'arctic', 'adult', 'chain', 'safety', 'broken', 'past',
        'general', 'farm', 'boring', 'mouse', 'green', 'obey', 'please',
        'hills', 'pass', 'unusual', 'pants', 'dare', 'kind', 'border', 'want',
        'reward', 'bright', 'meeting', 'swim', 'tool', 'rather', 'editor',
        'color', 'widow', 'excess', 'another', 'nights', 'horse', 'months',
        'discuss', 'example', 'mirror', 'grew', 'school', 'sort', 'sauce',
        'iron', 'confirm', 'of', 'peace', 'cook', 'blow', 'created', 'status',
        'machine', 'tore', 'nothing', 'trees', 'tissue', 'usage', 'ones',
        'both', 'consume', 'soup', 'user', 'exact', 'stamp', 'beam', 'item',
        'beaten', 'bean', 'sound', 'pay', 'medical', 'mother', 'army', 'cream',
        'method', 'remedy', 'easily', 'trial', 'stuff', 'hill', 'been', 'hard',
        'forms', 'stuck', 'station', 'upper', 'avenue', 'stiff', 'noise', 'map',
        'forced', 'tin', 'suddenly', 'natural', 'message', 'birds', 'action',
        'honour', 'diamond', 'clay', 'target', 'escape', 'rent', 'fits',
        'layer', 'imagine', 'pole', 'water', 'amongst', 'bear', 'bark', 'fry',
        'walls', 'spite', 'doubt', 'window', 'touch', 'worthy', 'pace',
        'brother', 'mine', 'fish', 'present', 'letter', 'expand', 'absent',
        'words', 'try', 'service', 'real', 'study', 'sir', 'carpet', 'sharp',
        'among', 'help', 'praise', 'however', 'admit', 'magic', 'seem', 'bad',
        'drink', 'good', 'convince', 'elderly', 'ridge', 'protect', 'dirt',
        'only', 'winter', 'scene', 'limits', 'entire', 'shock', 'till', 'verse',
        'quiet', 'dirty', 'big', 'hold', 'affair', 'canvas', 'event', 'mile',
        'table', 'prefer', 'feast', 'users', 'fetch', 'dog', 'steam', 'sung',
        'pains', 'modern', 'tone', 'value', 'his', 'hits', 'bills', 'product',
        'offer', 'names', 'bags', 'month', 'onion', 'loud', 'captain',
        'purpose', 'read', 'slope', 'apple', 'hut', 'machine', 'theory', 'can',
        'angry', 'fare', 'river', 'wide', 'import', 'mass', 'gun', 'upon',
        'condemn', 'vivid', 'horns', 'parts', 'inside', 'fail', 'look',
        'factory', 'partly', 'right', 'stand', 'fill', 'lows', 'object',
        'going', 'threat', 'got', 'speedy', 'minor', 'nine', 'hear', 'tunnel',
        'organ', 'troop', 'coins', 'secret', 'fright', 'whale', 'truly',
        'banana', 'rug', 'tulip', 'many', 'storm', 'worn', 'lot', 'murder',
        'hearts', 'memory', 'youth', 'article', 'cheap', 'use', 'hung',
        'special', 'sank', 'hit', 'queen', 'back', 'ideas', 'held', 'family',
        'nobody', 'male', 'sat', 'valid', 'format', 'aunt', 'sends', 'sin',
        'shoot', 'marry', 'lead', 'news', 'subway', 'argue', 'hell', 'mad',
        'days', 'should', 'stress', 'frost', 'won', 'heavy', 'attempt', 'team',
        'dish', 'worse', 'convert', 'appear', 'sword', 'flew', 'paying',
        'folks', 'couple', 'so', 'taken', 'loss', 'drawer', 'glad', 'year',
        'appoint', 'steel', 'less', 'unless', 'jar', 'dear', 'meet', 'allied',
        'death', 'side', 'tell', 'costs', 'believe', 'sacred', 'being',
        'advance', 'wing', 'record', 'attract', 'heel', 'march', 'suit',
        'consul', 'ice', 'photo', 'lack', 'regard', 'repeat', 'birth', 'greedy',
        'cut', 'enough', 'poet', 'any', 'market', 'listen', 'plan', 'skill',
        'bundle', 'happen', 'soon', 'depend', 'post', 'forever', 'locked',
        'ride', 'prove', 'pure', 'cancer', 'bother', 'fence', 'shine', 'dozen',
        'think', 'tank', 'cure', 'rush', 'feeling', 'wool', 'tube', 'funny',
        'indeed', 'start', 'however', 'daily', 'strain', 'senior', 'cost',
        'animal', 'made', 'bowl', 'egg', 'shell', 'nuts', 'desk', 'ago',
        'ought', 'cooks', 'course', 'shiver', 'pool', 'income', 'crayon',
        'ensure', 'tender', 'its', 'freeze', 'stars', 'valley', 'take', 'told',
        'spread', 'age', 'paper', 'rain', 'manner', 'red', 'her', 'clearly',
        'pity', 'stated', 'wipe', 'must', 'hero', 'waste', 'near', 'wine',
        'speed', 'does', 'he', 'milk', 'shelf', 'comfort', 'saying', 'watch',
        'step', 'dance', 'warmth', 'neck', 'feet', 'spin', 'belief', 'stick',
        'skin', 'cat', 'ward', 'fold', 'camp', 'stream', 'seldom', 'govern',
        'say', 'cafe', 'about', 'moment', 'grassy', 'cloud', 'error', 'herself',
        'rose', 'math', 'carbon', 'bones', 'hobby', 'sun', 'metal', 'reason',
        'company', 'convey', 'lights', 'work', 'eager', 'soil', 'yield',
        'applied', 'notes', 'yes', 'outside', 'nor', 'vast', 'burst', 'alert',
        'floor', 'bend', 'hatred', 'into', 'brutal', 'ground', 'fellow', 'it',
        'connect', 'pilot', 'wooden', 'faces', 'thank', 'resort', 'bishop',
        'stomach', 'out', 'hurt', 'public', 'losing', 'extra', 'forward',
        'finally', 'factor', 'unit', 'express', 'gotten', 'ten', 'conduct',
        'feel', 'fourth', 'after', 'barrel', 'cake', 'bride', 'bone', 'sit',
        'weeks', 'married', 'tide', 'drama', 'suggest', 'dinner', 'jacket',
        'mild', 'city', 'brains', 'blue', 'a', 'return', 'history', 'given',
        'wider', 'deal', 'stay', 'belt', 'genius', 'battery', 'eye', 'seed',
        'street', 'sands', 'appeal', 'unique', 'white', 'found', 'teach',
        'signal', 'them', 'black', 'compute', 'native', 'baby', 'uncle',
        'tenth', 'gross', 'cookie', 'palace', 'model', 'benefit', 'ignore',
        'text', 'last', 'store', 'frame', 'rooms', 'yours', 'writer', 'you',
        'hand', 'cuts', 'severe', 'crown', 'way', 'lower', 'purple', 'comment',
        'garden', 'first', 'led', 'pencil', 'nose', 'produce', 'silk', 'abroad',
        'sea', 'bus', 'heard', 'tiger', 'tear', 'entirely', 'rich', 'meat',
        'pen', 'brick', 'border', 'pools', 'stream', 'temple', 'submit',
        'clerk', 'holes', 'hint', 'hungry', 'salmon', 'griefs', 'since',
        'minus', 'helpful', 'despite', 'talks', 'live', 'up', 'fix', 'born',
        'catch', 'column', 'tune', 'wired', 'choose', 'ideal', 'ball', 'or',
        'blame', 'task', 'tooth', 'raise', 'concern', 'wiped', 'phase', 'built',
        'before', 'drag', 'bound', 'fully', 'scare', 'smell', 'bubble', 'score',
        'calm', 'title', 'banker', 'captain', 'slept', 'vision', 'ending',
        'motor', 'manage', 'improve', 'citizen', 'ballot', 'carry', 'three',
        'frog', 'plate', 'woman', 'nice', 'collar', 'exists', 'track',
        'history', 'delay', 'reign', 'client', 'crops', 'aspect', 'tea',
        'constantly', 'healthy', 'fairly', 'thread', 'provide', 'anxiety', 'in',
        'died', 'science', 'excuse', 'cave', 'mental', 'proof', 'besides',
        'there', 'college', 'full', 'arms', 'talk', 'coal', 'lovely', 'explain',
        'ashore', 'grown', 'often', 'plans', 'sits', 'jobs', 'doing', 'means',
        'candle', 'junior', 'forth', 'vary', 'liver', 'plus', 'thus', 'trick',
        'sixth', 'brown', 'curious', 'forget', 'may', 'fall', 'tired', 'parks',
        'dream', 'bull', 'long', 'obtain', 'while', 'planet', 'climate',
        'drawn', 'wind', 'hat', 'ratio', 'terms', 'ghost', 'energy', 'van',
        'scream', 'below', 'sheet', 'machine', 'maid', 'size', 'zero', 'united',
        'contact', 'refuse', 'mention', 'gulf', 'my', 'allows', 'from', 'deep',
        'measure', 'games', 'case', 'ants', 'maple', 'wrap', 'thing', 'estate',
        'saw', 'row', 'eight', 'compare', 'gray', 'let', 'random', 'homes',
        'call', 'mainly', 'curve', 'artist', 'awaken', 'dying', 'earth', 'toes',
        'lazy', 'civil', 'musical', 'retire', 'needs', 'shake', 'divide',
        'smoke', 'knew', 'differ', 'they', 'owe', 'our', 'hope', 'region',
        'wave', 'copy', 'sign', 'be', 'connect', 'dead', 'stolen', 'agent',
        'imagine', 'index', 'within', 'trust', 'might', 'sport', 'upset',
        'home', 'supper', 'repay', 'weed', 'foreign', 'at', 'light', 'close',
        'play', 'books', 'bow', 'stairs', 'twelve', 'deserve', 'yard', 'i',
        'young', 'half', 'mend', 'music', 'without', 'plain', 'trace', 'lifted',
        'conceal', 'trouble', 'exceed', 'thief', 'vain', 'whether', 'punish',
        'arch', 'airline', 'former', 'roast', 'speech', 'hid', 'eat', 'stir',
        'thin', 'bodies', 'date', 'tend', 'along', 'wall', 'through', 'plenty',
        'knot', 'problem', 'morning', 'needle', 'come', 'fond', 'cow', 'stood',
        'fewer', 'absorb', 'crawl', 'legal', 'concert', 'dawn', 'strap', 'bold',
        'sing', 'against', 'monkey', 'empty', 'future', 'shut', 'spice',
        'novel', 'pupil', 'loaded', 'college', 'relief', 'wage', 'craft',
        'round', 'compare', 'rang', 'device', 'arisen', 'scold', 'trunk', 'the',
        'make', 'laid', 'motion', 'supply', 'set', 'report', 'correct', 'towel',
        'forbid', 'fifty', 'rock', 'pie', 'sleep', 'car', 'oil', 'ability',
        'latter', 'double', 'winds', 'patent', 'tower', 'east', 'bag', 'holder',
        'joyful', 'venue', 'scheme', 'draw', 'sand', 'become', 'whom', 'mercy',
        'honest', 'myself', 'worry', 'reveal', 'bicycle', 'plane', 'root',
        'chance', 'rat', 'corner', 'stone', 'house', 'beneath', 'also', 'mouth',
        'element', 'loved', 'chicken', 'never', 'broadly', 'ivory', 'symbol',
        'dealer', 'moving', 'medium', 'during', 'sorts', 'faster', 'forest',
        'invite', 'arrest', 'class', 'regret', 'expense', 'statue', 'onto',
        'habit', 'low', 'crop', 'include', 'tick', 'unlike', 'around', 'screw',
        'west', 'pages', 'sky', 'bitter', 'create', 'gets', 'hands', 'edge',
        'suitably', 'send', 'huge', 'brand', 'harbor', 'have', 'render',
        'float', 'capital', 'what', 'on', 'polite', 'steps', 'tape', 'cursor',
        'rapid', 'grade', 'base', 'remain', 'result', 'consist', 'swung',
        'jokes', 'invent', 'none', 'better', 'except', 'no', 'lip', 'beauty',
        'another', 'sore', 'seven', 'ended', 'ready', 'load', 'folk', 'apply',
        'because', 'evening', 'powder', 'scale', 'board', 'field', 'contain',
        'people', 'fancy', 'nerve', 'reach', 'key', 'boots', 'grasp', 'crowd',
        'ships', 'issue', 'focus', 'self', 'least', 'once', 'press', 'third',
        'rude', 'settle', 'lay', 'bottle', 'lie', 'flame', 'library', 'irons',
        'anyway', 'site', 'ever', 'free', 'reflect', 'wrong', 'known', 'cups',
        'string', 'bike', 'hopes', 'shame', 'list', 'longer', 'excited',
        'insist', 'oils', 'dealt', 'pulse', 'cases', 'speak', 'panel', 'switch',
        'chart', 'paint', 'kill', 'audit', 'fans', 'flat', 'safe', 'video',
        'happy', 'but', 'roll', 'care', 'lion', 'orange', 'anyone', 'build',
        'their', 'brought', 'indoor', 'two', 'driver', 'serve', 'horror',
        'soul', 'films', 'center', 'sweet', 'degree', 'company', 'claim',
        'hotel', 'sides', 'cancel', 'boy', 'spring', 'sent', 'correct', 'book',
        'radio', 'prime', 'mix', 'pale', 'discuss', 'drift', 'slide', 'unable',
        'fleet', 'cart', 'fallen', 'august', 'card', 'bless', 'sets', 'silver',
        'trips', 'brother', 'profit', 'coin', 'wheel', 'body', 'large', 'pick',
        'oppose', 'drops', 'little', 'kinds', 'normal', 'sleeve', 'button',
        'husband', 'pain', 'boot', 'hide', 'toss', 'shed', 'lake', 'oxygen',
        'sail', 'walk', 'lies', 'cabinet', 'burden', 'north', 'colony', 'giant',
        'globe', 'taxi', 'castle', 'driven', 'earn', 'hidden', 'tomato',
        'shout', 'slave', 'hither', 'moon', 'tied', 'sought', 'how', 'keep',
        'narrow', 'ear', 'melt', 'fool', 'rough', 'lifted', 'thorn', 'bird',
        'to', 'private', 'killed', 'area', 'hot', 'desire', 'court', 'absence',
        'life', 'enemy', 'duck', 'tubes', 'until', 'pattern', 'develop',
        'pride', 'wire', 'comes', 'update', 'sample', 'space', 'lid', 'owns',
        'staff', 'detail', 'check', 'wet', 'rules', 'passed', 'fifth', 'basket',
        'swear', 'wants', 'talent', 'central', 'worker', 'okay', 'belong',
        'visual', 'thick', 'breath', 'girl', 'sweep', 'channel', 'rhythm',
        'porch', 'solid', 'ring', 'second', 'cast', 'fought', 'person',
        'hollow', 'wild', 'trap', 'word', 'law', 'lunch', 'asleep', 'sale',
        'apology', 'between', 'image', 'mind', 'awful', 'weak', 'best', 'tour',
        'battle', 'stock', 'length', 'boat', 'society',
    ];
}
