<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $post = fake()->unique()->randomElement([
            [
                'title' => 'How Binary Search Reduces a Problem in Half',
                'content' => 'Binary search finds a target in a sorted collection by comparing it with the middle element. If the target is smaller, the algorithm continues in the left half; otherwise, it continues in the right half. Each comparison removes roughly half of the remaining candidates, giving binary search a time complexity of O(log n). The tradeoff is that the data must already be sorted and support efficient access to its middle element.',
            ],
            [
                'title' => 'Understanding Stacks and Queues',
                'content' => 'Stacks and queues are simple data structures with very different access rules. A stack uses last-in, first-out ordering and is useful for function calls, undo operations, and depth-first search. A queue uses first-in, first-out ordering and is useful for task scheduling, breadth-first search, and message processing. Choosing the right structure makes the intended order of work explicit.',
            ],
            [
                'title' => 'Why Hash Tables Are So Fast',
                'content' => 'A hash table stores values by converting a key into an array index with a hash function. With a well-distributed hash function, lookup, insertion, and deletion are typically O(1) on average. Collisions still occur, so implementations use techniques such as separate chaining or open addressing. Performance depends on the load factor and on how evenly keys are distributed.',
            ],
            [
                'title' => 'Recursion and the Call Stack',
                'content' => 'A recursive function solves a problem by calling itself with a smaller input until it reaches a base case. Every call creates a stack frame containing its local state, which is why missing or incorrect base cases can cause stack overflow errors. Recursion is elegant for trees and divide-and-conquer algorithms, although an iterative solution may use less memory for very deep inputs.',
            ],
            [
                'title' => 'Database Indexes and Query Performance',
                'content' => 'A database index is an additional data structure that helps the database locate rows without scanning an entire table. B-tree indexes are effective for equality and range queries, while composite indexes can support queries involving several columns. Indexes improve reads but add storage and write costs, so they should be designed around real query patterns rather than added to every column.',
            ],
            [
                'title' => 'How HTTP Requests Reach a Web Application',
                'content' => 'When a browser requests a page, DNS resolves the domain name to an address and the client opens a connection to the server. The browser sends an HTTP request containing a method, path, headers, and sometimes a body. The server processes the request and returns a status code, headers, and response content. Understanding this sequence makes debugging redirects, authentication, and caching much easier.',
            ],
            [
                'title' => 'Processes, Threads, and Concurrency',
                'content' => 'A process owns its memory and resources, while threads are execution paths that share memory inside a process. Threads can make I/O-heavy programs more responsive, but shared state introduces race conditions. Synchronization tools such as locks, semaphores, and message passing help coordinate concurrent work. Good designs minimize shared mutable state because coordination itself has a cost.',
            ],
            [
                'title' => 'Virtual Memory in Operating Systems',
                'content' => 'Virtual memory gives each process the impression that it owns a large, private address space. The operating system maps virtual addresses to physical memory pages and can move inactive pages to disk when RAM is limited. This isolation improves security and simplifies application development, but excessive paging causes slowdowns known as thrashing. Efficient programs work with memory locality rather than relying on unlimited RAM.',
            ],
            [
                'title' => 'The Role of Algorithms in Machine Learning',
                'content' => 'Machine learning algorithms learn patterns from examples instead of relying entirely on hand-written rules. During training, a model adjusts its parameters to reduce a loss function, and validation data helps measure how well it generalizes. A model that memorizes its training data may overfit, while an overly simple model may underfit. Data quality, feature selection, and evaluation design are as important as the algorithm itself.',
            ],
            [
                'title' => 'Public-Key Cryptography Explained',
                'content' => 'Public-key cryptography uses a mathematically related public key and private key. Anyone can use the public key to encrypt a message or verify a signature, while only the private key should decrypt or create the corresponding result. In practice, protocols combine asymmetric cryptography for identity and key exchange with symmetric encryption for efficient data transfer.',
            ],
            [
                'title' => 'What Makes an API Reliable',
                'content' => 'A reliable API has clear resource names, predictable status codes, consistent validation errors, and documented request and response formats. Idempotent operations allow clients to retry safely when a network failure occurs. Authentication, authorization, rate limits, and structured logging protect both the service and its consumers. Reliability is a property of the contract and its operational behavior, not only of the controller code.',
            ],
            [
                'title' => 'Version Control with Git',
                'content' => 'Git records changes as a directed graph of commits, allowing developers to inspect history, create branches, and merge work. A commit should represent one coherent change and should be easy for another developer to review. Branches are lightweight references, while the repository history preserves the actual snapshots. Understanding this model makes rebasing and conflict resolution less mysterious.',
            ],
            [
                'title' => 'The Difference Between Compilation and Interpretation',
                'content' => 'A compiler translates source code into another form before execution, often producing machine code or an intermediate representation. An interpreter executes instructions at runtime, although modern runtimes frequently combine interpretation with just-in-time compilation. The distinction affects startup time, optimization, portability, and debugging. Many production languages use a hybrid approach rather than fitting perfectly into one category.',
            ],
            [
                'title' => 'Graph Traversal with BFS and DFS',
                'content' => 'Breadth-first search explores a graph level by level using a queue, which makes it useful for finding the shortest path in an unweighted graph. Depth-first search follows one path as far as possible before backtracking, usually using recursion or a stack. Both algorithms run in O(V + E) time with an adjacency-list representation, but they produce different exploration orders and support different problem-solving strategies.',
            ],
            [
                'title' => 'Clean Code and Separation of Concerns',
                'content' => 'Software becomes easier to change when each part has a focused responsibility and communicates through a clear interface. Separating persistence, domain rules, and presentation reduces the number of reasons a class or function needs to change. Small names, meaningful tests, and explicit dependencies make behavior easier to understand. Clean code is less about style preferences and more about reducing the cost of future changes.',
            ],
        ]);

        return [
            'user_id' => User::factory(),
            'title' => $post['title'],
            'slug' => Str::slug($post['title']).'-'.Str::random(6),
            'content' => $post['content'],
        ];
    }
}
